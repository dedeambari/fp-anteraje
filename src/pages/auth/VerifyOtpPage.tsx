import { useNavigate } from "react-router-dom";
import { useState, useRef, useEffect } from "react";
import toast, { LoaderIcon } from "react-hot-toast";
import { useForgotPasswordStore } from "@/store/useForgotPasswordStore";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";
import { GoShieldLock } from "react-icons/go";
import { axiosInstance } from "@/lib/axios";

const VerifyOtpPage = () => {
  const { reset, setOtp: setForgotOtp, username } = useForgotPasswordStore();
  const [otp, setOtp] = useState<string[]>(Array(6).fill(""));
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const inputRefs = useRef<HTMLInputElement[]>([]);

  const handleBack = () => {
    navigate("/forgot-password");
    reset();
  };

  const handleChange = (index: number, value: string) => {
    if (/^\d*$/.test(value) && value.length <= 1) {
      const newOtp = [...otp];
      newOtp[index] = value;
      setOtp(newOtp);

      // Auto focus to next input
      if (value && index < 5) {
        inputRefs.current[index + 1]?.focus();
      }
    }
  };

  const handleKeyDown = (index: number, e: React.KeyboardEvent) => {
    if (e.key === "Backspace" && !otp[index] && index > 0) {
      inputRefs.current[index - 1]?.focus();
    }
  };

  const handlePaste = (e: React.ClipboardEvent) => {
    e.preventDefault();
    const pasteData = e.clipboardData.getData("text").slice(0, 6);
    if (/^\d+$/.test(pasteData)) {
      const newOtp = [...otp];
      pasteData.split("").forEach((char, i) => {
        if (i < 6) newOtp[i] = char;
      });
      setOtp(newOtp);
    }
  };

  const handleVerify = async (e: React.FormEvent) => {
    e.preventDefault();
    const otpString = otp.join("");
    if (otpString.length !== 6) {
      toast.error("Harap masukkan 6 digit OTP");
      return;
    }

    setLoading(true);
    try {
      await axiosInstance.post("/staf/forgot-password/verify-otp", {
        username,
        otp: otpString,
      });
      setForgotOtp(otpString);
      toast.success("OTP valid, lanjut ubah password");
      navigate("/reset-password");
    } catch (err: any) {
      toast.error(err.response?.data?.message || "OTP tidak valid");
    } finally {
      setLoading(false);
    }
  };

  // Auto focus first input on mount
  useEffect(() => {
    inputRefs.current[0]?.focus();
  }, []);


  useEffect(() => {
    if (!username) {
      navigate("/login");
      reset();
    }
  }, [username, navigate, reset]);

  return (
    <div className="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl overflow-hidden border border-white/20 w-full">
      <div className="py-8 px-4">
        <div className="mb-8 text-center">
          <GoShieldLock className="mx-auto text-4xl text-white mb-4" />
          <h1 className="text-2xl font-bold text-white">Verifikasi OTP</h1>
          <p className="text-white/80 mt-2">Masukkan 6 digit kode OTP dari admin</p>
        </div>

        <form onSubmit={handleVerify} className="space-y-6">
          <div className="flex justify-center gap-3 mb-8">
            {Array.from({ length: 6 }).map((_, index) => (
              <input
                key={index}
                ref={(el) => {
                  inputRefs.current[index] = el!;
                }}
                type="text"
                inputMode="numeric"
                pattern="\d*"
                maxLength={1}
                value={otp[index]}
                onChange={(e) => handleChange(index, e.target.value)}
                onKeyDown={(e) => handleKeyDown(index, e)}
                onPaste={handlePaste}
                className="w-10 h-14 text-xl text-center bg-white/10 border-2 border-white/20 rounded-lg text-white focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/30"
                autoComplete="off"
              />
            ))}
          </div>

          <div className="flex justify-between">
            <button
              type="button"
              onClick={handleBack}
              className="btn btn-info"
            >
              <FaArrowLeft className="mr-2" />
              Kembali
            </button>
            <button
              type="submit"
              className="btn btn-secondary"
              disabled={loading || otp.join("").length !== 6}
            >
              {loading ? (
                <>
                  <LoaderIcon className="h-5 w-5 animate-spin mr-2" />
                  Memverifikasi...
                </>
              ) : (
                <>
                  Verifikasi
                  <FaArrowRight className="ml-2" />
                </>
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default VerifyOtpPage;