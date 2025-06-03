import {
  Navigate,
  Route,
  Routes,
  useLocation,
  useNavigate
} from "react-router-dom";
import { useEffect, useRef, useState } from "react";

import toast from "react-hot-toast";
import { useAuthStore } from "@/store/useAuthStore";

// Pages Auth
import AuthPage from "@/pages/auth/AuthPage";

// Pages Tabs
import { useAppBootstrapStore } from "@/store/useAppBootstrapStore";
import TabsPage from "@/pages/tabs/TabsPage";
import DetailBarangPage from "@/pages/tabs/DetailBarangPage";

// Components
import { setupStatusBar } from "@/components/setupStatusBar";
import SplashScreen from "@/components/SplashScreen";
import ToastCustom from "@/components/ToastCustom";

import { Network } from "@capacitor/network";
import { Keyboard, KeyboardResize } from "@capacitor/keyboard";
import { useTabStore } from "@/store/useTabsStore";
import { App as CapacitorApp } from "@capacitor/app";
import type { PluginListenerHandle } from "@capacitor/core";
import { Capacitor} from "@capacitor/core"

const App = () => {
  // Auth
  const { authUser, checkAuth, isCheckingAuth } = useAuthStore();
  // App bootstrap
  const { isBootstrapping, bootstrapApp } = useAppBootstrapStore();
  const [hasBootstrapped, setHasBootstrapped] = useState(false);

  // Network
  const [networkStatus, setNetworkStatus] = useState<string | null>(null);

  // Handle back action
  const location = useLocation();
  const navigate = useNavigate();
  const { activeTab, setActiveTab } = useTabStore();

  // HAndle Back Tap and Timeout
  const tapRef = useRef(0);
  const timeoutRef = useRef<NodeJS.Timeout | null>(null);
  const listenerRef = useRef<PluginListenerHandle | null>(null);

  // Keyboard
  useEffect(() => {
    if (Capacitor.getPlatform() == 'web' && 'ios') return;
    Keyboard.setScroll({ isDisabled: false });
    Keyboard.setResizeMode({ mode: KeyboardResize.Native });
  }, []);

  // Cek auth
  useEffect(() => {
    const runCheck = async () => {
      try {
        if (checkAuth) await checkAuth(true);
      } catch (error: any) {
        toast.error("Gagal cek auth" + error.message);
      }
    };

    runCheck();
  }, [checkAuth]);

  // Hit endpoint bootstrap
  useEffect(() => {
    if (authUser && !hasBootstrapped) {
      bootstrapApp().then(() => {
        setHasBootstrapped(true);
      });
    }
  }, [authUser, hasBootstrapped, bootstrapApp]);

  // Reset hasBootstrapped
  useEffect(() => {
    if (!authUser) {
      setHasBootstrapped(false);
    }
  }, [authUser]);

  // Setup status bar
  useEffect(() => {
    setupStatusBar(isCheckingAuth, hasBootstrapped, isBootstrapping, authUser);
  }, [isCheckingAuth, hasBootstrapped, isBootstrapping, authUser]);

  // Network
  // Listen & set state saat mount
  useEffect(() => {
    let mounted = true;

    if (Capacitor.getPlatform() == 'web') return;

    const setupNetwork = async () => {
      const status = await Network.getStatus();
      if (mounted) {
        const conn = status.connected ? "online" : "offline";
        setNetworkStatus(conn);
        if (!status.connected) toast.error("Tidak ada koneksi internet");
      }
    };

    setupNetwork();

    const listener = Network.addListener("networkStatusChange", (status) => {
      const conn = status.connected ? "online" : "offline";
      setNetworkStatus(conn);
      if (!status.connected) {
        toast.error("Tidak ada koneksi internet");
      }
    });

    return () => {
      mounted = false;
      listener.then((h) => h.remove());
    };
  }, []);

  // Back button handler
  useEffect(() => {
    if (Capacitor.getPlatform() == 'web') return;
    // Reset tiap kali kondisi berubah
    tapRef.current = 0;
    if (timeoutRef.current) {
      clearTimeout(timeoutRef.current);
      timeoutRef.current = null;
    }

    // Listener back
    const backAction = () => {
      // Tutup modal
      const modal = document.getElementById("modal-update-prosess") as HTMLDialogElement;
      if (modal !== null) {
        if (modal.open) modal.close();
      }
      const currentPath = location.pathname;
      // Kalau belum login, listener back untuk auth pages
      if (!authUser) {
        const isOnLoginPage = currentPath === "/login";
        if (isOnLoginPage) {
          tapRef.current += 1;
          if (tapRef.current === 1) {
            ToastCustom({ message: "Tekan sekali lagi untuk keluar" });
            if (timeoutRef.current) clearTimeout(timeoutRef.current);
            timeoutRef.current = setTimeout(() => {
              tapRef.current = 0;
              timeoutRef.current = null;
            }, 3000);
          } else if (tapRef.current === 2) {
            CapacitorApp.exitApp();
          }
        } else {
          navigate("/login");
        }
        return;
      }

      // Kalau sudah login, cek activeTab
      if (authUser && activeTab === "home" && currentPath === "/") {
        navigate("/");
        tapRef.current += 1;
        if (tapRef.current === 1) {
          ToastCustom({ message: "Tekan sekali lagi untuk keluar" });
          if (timeoutRef.current) clearTimeout(timeoutRef.current);
          timeoutRef.current = setTimeout(() => {
            tapRef.current = 0;
            timeoutRef.current = null;
          }, 3000);
        } else if (tapRef.current === 2) {
          CapacitorApp.exitApp();
        }
      } else if (authUser && activeTab !== "home" && currentPath === "/") {
        navigate("/");
        setActiveTab("home");
      } else {
        console.log("active tab", activeTab);
        navigate(-1);
      }

    };

    const setupListener = async () => {
      listenerRef.current = await CapacitorApp.addListener("backButton", backAction);
    };

    setupListener();

    return () => {
      listenerRef.current?.remove();
      listenerRef.current = null;

      if (timeoutRef.current) {
        clearTimeout(timeoutRef.current);
        timeoutRef.current = null;
      }
    };
  }, [authUser, activeTab, location.pathname, navigate, setActiveTab]);

  // Splash screen reason
  const getSplashReason = () => {
    if (isCheckingAuth) return "Setup aplikasi...";
    if (networkStatus === "offline") return "Tidak ada koneksi internet...";
    if (authUser && (isBootstrapping || !hasBootstrapped)) return "Memuat...";
    return "";
  };

  // Loading screen
  if (
    isCheckingAuth ||
    networkStatus === "offline" ||
    (authUser && (isBootstrapping || !hasBootstrapped))
  ) {
    return <SplashScreen message={getSplashReason()} />;
  }

  return (
    <Routes>
      <Route
        path="/"
        element={authUser ? <TabsPage /> : <Navigate to="/login" />}
      />
      <Route
        path="/detail"
        element={authUser ? <DetailBarangPage /> : <Navigate to="/login" />}
      />
      <Route
        path="/login"
        element={!authUser ? <AuthPage typeAuth="login" /> : <Navigate to="/" />}
      />
      <Route path="/forgot-password" element={<AuthPage typeAuth="forgot-password" />} />
      <Route path="/verify-otp" element={<AuthPage typeAuth="verify-otp" />} />
      <Route path="/reset-password" element={<AuthPage typeAuth="reset-password" />} />
    </Routes>
  );
};
export default App;
