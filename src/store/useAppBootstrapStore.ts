import { create } from 'zustand';
import { useHomeStore } from '@/store/useHomeStore';
import { useTaskStore } from '@/store/useTaskStore';

type AppBootstrapState = {
  isBootstrapping: boolean;
  bootstrapApp: () => Promise<void>;
};

export const useAppBootstrapStore = create<AppBootstrapState>((set) => ({
  isBootstrapping: true,
  bootstrapApp: async () => {
    set({ isBootstrapping: true });

    try {
      await Promise.all([
        useHomeStore.getState().fetchHome(),
        useTaskStore.getState().fetchTask(),
        // useProfileStore.getState().fetchProfile()
      ]);
    } catch (err) {
      console.error('Bootstrap error:', err);
    } finally {
      set({ isBootstrapping: false });
    }
  },

}));
