import { create } from "zustand";
import { axiosInstance } from "@/lib/axios";
import type { DataItem, ResponseDetailBarang, ResponseTask } from "@/types";
import { useHomeStore } from "@/store/useHomeStore";
import type { AxiosResponse } from "axios";

type TaskState = {
	data: ResponseTask | null;
	loading: boolean;
	dataDetailBarang?: ResponseDetailBarang | null;
	isLoadingDetailBarang?: number | null;
	isLoadingUpdateProsess?: boolean;
	selectedBarang?: DataItem | null;
	setSelectedBarang: (barang: DataItem | null) => void;
	fetchTask: () => Promise<void>;
	fetchDetailBarang?: (id_barang: number) => Promise<void>;
	updateProsess: (formData: FormData) => Promise<AxiosResponse>;
	swipteModal: boolean;
	setSwipteModal: (value: boolean) => void;
};

export const useTaskStore = create<TaskState>((set, get) => ({
	data: null,
	loading: false,
	selectedBarang: null,
	setSelectedBarang: (barang) => set({ selectedBarang: barang }),
	swipteModal: false,
	setSwipteModal: (value) => set({ swipteModal: value }),

	fetchTask: async () => {
		set({ loading: true });
		try {
			const response = await axiosInstance.get("/staf/task");
			set({ data: response.data });
		} catch (err) {
			console.error("Error fetching home data", err);
		} finally {
			set({ loading: false });
		}
	},

	fetchDetailBarang: async (id_barang) => {
		set({ isLoadingDetailBarang: id_barang });
		try {
			const response = await axiosInstance.get("/staf/task/detail-barang", {
				params: {
					id_barang: id_barang
				}
			});
			set({ dataDetailBarang: response.data });
		} catch (err) {
			console.error("Error fetching home data", err);
		} finally {
			set({ isLoadingDetailBarang: null });
		}
	},

	updateProsess: async (formData) => {
		set({ isLoadingUpdateProsess: true });

		try {
			const response = await axiosInstance.post(
				"/staf/task/update-prosess",
				formData,
				{
					headers: {
						"Content-Type": "multipart/form-data"
					}
				}
			);

			if (response) {
				await Promise.all([
					get().fetchTask(),
					useHomeStore.getState().fetchHome()
				]);
			}

			// Kembalikan response untuk ditangani di UI
			console.log(response);
			return response;
		} catch (err: any) {
			console.log(err);
			throw new Error(err.response.data.message);
		} finally {
			set({ isLoadingUpdateProsess: false });
		}
	}

}));
