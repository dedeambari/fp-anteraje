import { create } from 'zustand';

interface TabStore {
  activeTab: string;
  activeTabTask: "diproses" | "diantar" | "diterima";
  setActiveTab: (tab: string) => void;
  setActiveTabTask: (tab: "diproses" | "diantar" | "diterima") => void;
}

export const useTabStore = create<TabStore>((set) => ({
  activeTab: 'home',
  activeTabTask: 'diproses',
  setActiveTab: (tab) => set({ activeTab: tab }),
  setActiveTabTask: (tab) => set({ activeTabTask: tab }),
}));
