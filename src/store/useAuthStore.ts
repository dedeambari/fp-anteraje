import { create } from "zustand";
import { axiosInstance } from "@/lib/axios";
import toast from "react-hot-toast";
import type { ResponseAuth } from "@/types";

interface LoginData {
	username: string;
	password: string;
}

interface AuthStore {
	authUser: ResponseAuth | null;
	isLoggingIn: boolean;
	isUpdatingProfile: boolean;
	isCheckingAuth: boolean;

	checkAuth: (suppressToast?: boolean) => Promise<void>;
	login: (data: LoginData) => Promise<void>;
	logout: () => Promise<void>;
	updateProfile: (data: FormData) => Promise<void>;
}

export const useAuthStore = create<AuthStore>((set, get) => ({
	authUser: null,
	isLoggingIn: false,
	isUpdatingProfile: false,
	isCheckingAuth: true,

	checkAuth: async (suppressToast = false) => {
		const token = localStorage.getItem("token");
		if (token) {
			axiosInstance.defaults.headers.common[
				"Authorization"
			] = `Bearer ${token}`;
		}
		try {
			const res = await axiosInstance.get<ResponseAuth>("/staf/check-auth");
			set({ authUser: res.data });
			if (!suppressToast) {
				toast.success(`Welcome back, ${res.data.staf.nama}`);
			}
		} catch (error: any) {
			if (error.response?.status === 401) {
				set({ authUser: null });
			} else {
				console.error("Error during checkAuth:", error);
			}
		} finally {
			set({ isCheckingAuth: false });
		}
	},

	login: async (data: LoginData) => {
		set({ isLoggingIn: true });
		try {
			const res = await axiosInstance.post<ResponseAuth>("/staf/login", data);
			const token = res.data.token;

			axiosInstance.defaults.headers.common[
				"Authorization"
			] = `Bearer ${token}`;
			localStorage.setItem("token", token);

			set({ authUser: res.data });
			toast.success("Logged in successfully");
		} catch (error: any) {
			toast.error(error.response?.data?.message || "Login failed");
		} finally {
			set({ isLoggingIn: false });
		}
	},

	logout: async () => {
		const logoutPromise = axiosInstance.post("/staf/logout");

		toast.promise(logoutPromise, {
			loading: "Logging out...",
			success: "Logged out successfully",
			error: (err) => err.response?.data?.message || "Logout failed"
		});

		try {
			await logoutPromise;
		} catch (error) {
			console.error("Error during logout:", error);
		} finally {
			localStorage.removeItem("token");
			delete axiosInstance.defaults.headers.common["Authorization"];
			set({ authUser: null });
		}
	},

	updateProfile: async (data: FormData) => {
		set({ isUpdatingProfile: true });
		try {
			const res = await axiosInstance.post("/staf/profile/update", data, {
				headers: {
					"Content-Type": "multipart/form-data"
				}
			});

			if (res.data?.data) {
				const updatedAuth = {
					...get().authUser,
					staf: res.data.data
				} as ResponseAuth;
				set({ authUser: updatedAuth });
				toast.success(res.data.message);
			}
		} catch (error: any) {
			toast.error(error.response?.data?.message || "Update profile failed");
		} finally {
			set({ isUpdatingProfile: false });
		}
	}
}));
