import { useTabStore } from "@/store/useTabsStore";
import { IoHome, IoHomeOutline } from "react-icons/io5";
import { RiTaskFill, RiTaskLine } from "react-icons/ri";
import { FaRegUser, FaUser } from "react-icons/fa";

const Tabs = () => {
  const { activeTab, setActiveTab } = useTabStore();

  const tabs = [
    { key: 'home', label: 'Home', icon: activeTab === 'home' ? <IoHome size={20} /> : <IoHomeOutline size={20} /> },
    { key: 'task', label: 'Task', icon: activeTab === 'task' ? <RiTaskFill size={20} /> : <RiTaskLine size={20} /> },
    { key: 'profile', label: 'Profile', icon: activeTab === 'profile' ? <FaUser size={20} /> : <FaRegUser size={20} /> },
  ];

  return (
    <div className="w-full bg-base-100 shadow-[0_-2px_5px_rgba(0,0,0,0.10)] flex justify-around py-2 rounded-t-xl">
      {tabs.map((tab) => (
        <button
          key={tab.key}
          onClick={() => setActiveTab(tab.key)}
          className={`flex flex-col items-center gap-1 text-sm transition-all duration-200 px-3 py-2
            ${activeTab === tab.key
              ? 'text-primary font-semibold'
              : ''
            }
            `}
        >
          <span
            className={`px-4 py-2 rounded-full ${activeTab === tab.key
                ? 'bg-primary text-white'
                : ''
              }`}
          >{tab.icon}</span>
          <span
            className={`text-base-content ${activeTab === tab.key
                ? 'font-semibold text-primary'
                : ''
              }`}
          >{tab.label}</span>
        </button>
      ))}
    </div>
  );
};

export default Tabs;
