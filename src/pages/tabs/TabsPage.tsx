import { useTabStore } from "@/store/useTabsStore";
import Tabs from "@/components/Tabs";
import HomePage from "@/pages/tabs/HomePage";
import TaskPage from "@/pages/tabs/TaskPage";
import ProfilePage from "@/pages/tabs/ProfilePage";

import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import { useEffect, useState } from "react";
import Header from "@/components/Header";
import type { Staf } from "@/types";
import { useAuthStore } from "@/store/useAuthStore";
import { FaCar, FaMotorcycle } from "react-icons/fa";

const TabsPage = () => {
  const { activeTab, setActiveTab } = useTabStore();
  const [swiperRef, setSwiperRef] = useState<any>(null);
  const { authUser } = useAuthStore();
  const data = authUser?.staf as Staf;

  const tabIndexMap: Record<string, number> = {
    home: 0,
    task: 1,
    profile: 2,
  };

  const tabKeys = ["home", "task", "profile"];

  useEffect(() => {
    if (swiperRef && typeof tabIndexMap[activeTab] !== "undefined") {
      swiperRef.slideTo(tabIndexMap[activeTab]);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [activeTab, swiperRef]);

  return (
    <div className="bg-base-300">
      {activeTab !== "home" ?
        (<Header>
          <h1 className="text-xl font-semibold capitalize py-4">{activeTab}</h1>
        </Header>) : (
          <Header>
            <div className="flex items-center gap-4 justify-start py-[8.7px]">
              <div className="flex items-center gap-3">
                <div className="avatar p-0">
                  <div className="mask mask-squircle w-10 h-10 text-base-100">
                    {data.profile ? (
                      <img src={import.meta.env.VITE_API_URL.replace("/api", "") + "/storage/" + data.profile} alt="avatar" className="w-full h-full object-cover" />
                    ) : (
                      <span className="text-xl w-full h-full flex items-center justify-center bg-primary">
                        {data?.nama?.slice(0, 2)?.toUpperCase() || "ST"}
                      </span>
                    )}
                  </div>
                </div>
                <div className="flex flex-col transition-all duration-300 -gap-1">
                  <div className="text-[15px] font-bold flex gap-1">{data?.nama || "Nama Pengguna"}
                    <span>
                      {data.transportasi === 'motor' ? (
                        <FaMotorcycle size={12} />
                      ) : (
                        <FaCar size={12} />
                      )}
                    </span>
                  </div>
                  <div className={`transition-opacity duration-300 `}>
                    <p className="opacity-75 text-xs">
                      <span className="badge badge-sm badge-accent px-1 font-semibold badge-soft font-mono">@{data?.username || "username"}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </Header>
        )
      }
      <Swiper
        autoHeight={true}
        onSwiper={setSwiperRef}
        onSlideChange={(swiper) => {
          const newTab = tabKeys[swiper.activeIndex];
          if (newTab) setActiveTab(newTab);
        }}
        resizeObserver={true}
        observer={true}
        observeParents={true}
        allowTouchMove={true}
      >
        <SwiperSlide><HomePage /></SwiperSlide>
        <SwiperSlide><TaskPage /></SwiperSlide>
        <SwiperSlide><ProfilePage /></SwiperSlide>

      </Swiper>

      <div className="fixed bottom-0 left-0 right-0 z-50 py-2">
        <Tabs />
      </div>
    </div>
  );
};

export default TabsPage;
