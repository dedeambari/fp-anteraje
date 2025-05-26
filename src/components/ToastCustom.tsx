import toast from "react-hot-toast";
import logo from "@/assets/logo-placeholder.svg";

interface ToastCustomProps {
  message?: string;
}

const ToastCustom = ({ message }: ToastCustomProps) => {
  return toast.custom((t) => {
    return (
      <div
        className={`${t.visible ? "animate-enter" : "animate-leave"
          } w-max bg-white shadow-lg rounded-full pointer-events-auto flex ring-1 ring-black ring-opacity-5`}
      >
        <div className="flex-1 p-2 flex items-center gap-3">
          <img src={logo} alt="App Logo" className="w-6 h-6" />
          <p className="text-sm font-medium text-gray-900">{message}</p>
        </div>
      </div>
    );
  }, { duration: 1000 });
};

export default ToastCustom;
