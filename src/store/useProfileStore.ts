import { create } from 'zustand';
import { axiosInstance } from '@/lib/axios';
import type { ResponseTask } from '@/types';

type ProfileState = {
	data: ResponseTask | null;
	loading: boolean;
	fetchTask: () => Promise<void>;
	fetchLogout?: () => Promise<void>;
};

export const useTaskStore = create<ProfileState>((set) => ({
	data: null,
	loading: false,
	fetchTask: async () => {
		set({ loading: true });
		try {
			const response = await axiosInstance.get('/staf/task');
			set({ data: response.data });
		} catch (err) {
			console.error("Error fetching home data", err);
		} finally {
			set({ loading: false });
		}
	},
}));
