import { useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import toast, { LoaderIcon } from "react-hot-toast";
import { FaArrowLeft } from "react-icons/fa";
import { useForgotPasswordStore } from "@/store/useForgotPasswordStore";
import { axiosInstance } from "@/lib/axios";
import { FiEye, FiEyeOff } from "react-icons/fi";

const ResetPasswordPage = () => {
  const { username, otp, reset } = useForgotPasswordStore()
  const [formData, setFormData] = useState({ newPassword: "", newPasswordConfirmation: "" });
  const { newPassword, newPasswordConfirmation } = formData;
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState({
    new: false,
    confirm: false
  });
  const navigate = useNavigate();

  const handleBack = () => {
    navigate("/verify-otp");
    reset();
  };

  const togglePassword = (field: keyof typeof showPassword) => {
    setShowPassword(prev => ({ ...prev, [field]: !prev[field] }));
  };

  const handleReset = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      await axiosInstance.post("/staf/forgot-password/reset", {
        username,
        otp,
        new_password: newPassword,
        new_password_confirmation: newPasswordConfirmation
      });
      navigate("/login");
      toast.success("Password berhasil diubah");
      reset();
      setLoading(false);
    } catch (err: any) {
      toast.error(err.response?.data?.message || "Gagal ubah password");
      setLoading(false);
    }
  };

  useEffect(() => {
    if (!username && !otp) {
      navigate("/login");
      reset();
    }
  }, [username, navigate, reset, otp]);

  return (
    <div className="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl overflow-hidden border border-white/20 w-full">
      <div className="py-8 px-4 w-full">
        <div className="mb-8 text-center">
          <h1 className="text-2xl font-bold text-white">Reset Password</h1>
          <p className="text-white/80 mt-1">Ubah password anda disini</p>
        </div>

        {/* Form */}
        <form onSubmit={handleReset} className="space-y-6">
          <div className="space-y-6">
            <div className="form-control flex flex-col w-full mb-4">
              <label className="label-text text-base-100">Password Baru</label>
              <label className="input rounded-xl input-secondary bg-transparent focus-within:bg-white/20 w-full text-white placeholder-white/50 border-white/20 focus:border-white/50 focus:bg-white/10">
                <input
                  type={showPassword.new ? "text" : "password"}
                  name="new_password"
                  value={newPassword}
                  onChange={(e) => setFormData({ ...formData, newPassword: e.target.value })}
                  placeholder="Masukkan password baru"
                />
                <button
                  type="button"
                  className="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer"
                  onClick={() => togglePassword('new')}
                >
                  {showPassword.new ? <FiEye /> : <FiEyeOff />}
                </button>
              </label>
            </div>
            <div className="form-control flex flex-col w-full mb-4">
              <label className="label-text text-base-100">Konfirmasi Password Baru</label>
              <label className="input rounded-xl input-secondary bg-transparent focus-within:bg-white/20 w-full text-white placeholder-white/50 border-white/20 focus:border-white/50 focus:bg-white/10">
                <input
                  type={showPassword.confirm ? "text" : "password"}
                  name="new_password_confirmation"
                  value={newPasswordConfirmation}
                  onChange={(e) => setFormData({ ...formData, newPasswordConfirmation: e.target.value })}
                  placeholder="Masukkan konfirmasi password baru"
                />
                <button
                  type="button"
                  className="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer"
                  onClick={() => togglePassword('confirm')}
                >
                  {showPassword.confirm ? <FiEye /> : <FiEyeOff />}
                </button>
              </label>
            </div>
          </div>

          {/* Submit Button */}
          <div className="flex justify-between">
            <button type="button" onClick={handleBack} className="btn btn-info">
              <FaArrowLeft />	Kembali
            </button>
            <button className="btn btn-secondary" type="submit"
              disabled={loading}
            >
              {loading ? (
                <>
                  <span className="ml-2">Loading</span>
                  <LoaderIcon className="h-5 w-5 animate-spin" />
                </>
              ) : (
                <>
                  <span>Reset Password</span>
                </>
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ResetPasswordPage;
