import { create } from 'zustand';
import { axiosInstance } from '@/lib/axios';
import type { ResponseHome } from '@/types';

type HomeState = {
  data: ResponseHome | null;
  loading: boolean;
  fetchHome: () => Promise<void>;
};

export const useHomeStore = create<HomeState>((set) => ({
  data: null,
  loading: false,
  fetchHome: async () => {
    set({ loading: true });
    try {
      const response = await axiosInstance.get('/staf/home');
      set({ data: response.data });
    } catch (err) {
      console.error("Error fetching home data", err);
    } finally {
      set({ loading: false });
    }
  },
}));
