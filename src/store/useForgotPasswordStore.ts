import { create } from "zustand";

interface ForgotPasswordStore {
  username: string;
  otp: string;
  setUsername: (username: string) => void;
  setOtp: (otp: string) => void;
  reset: () => void;
}

export const useForgotPasswordStore = create<ForgotPasswordStore>((set) => ({
  username: "",
  otp: "",
  setUsername: (username) => set({ username }),
  setOtp: (otp) => set({ otp }),
  reset: () => set({ username: "", otp: "" }),
}));
