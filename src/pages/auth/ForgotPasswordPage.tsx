import { useState } from "react";
import toast, { LoaderIcon } from "react-hot-toast";
import { useNavigate } from "react-router-dom";
import { FiUser } from "react-icons/fi";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";
import { axiosInstance } from "@/lib/axios";
import { useForgotPasswordStore } from "@/store/useForgotPasswordStore";

const ForgotPasswordPage = () => {
	const [username, setUsername] = useState("");
	const [loading, setLoading] = useState(false);
	const navigate = useNavigate();
	const { reset, setUsername: setForgotUsername } = useForgotPasswordStore();

	const handleBack = () => {
		navigate("/login");
		reset();
	};

	const handleSubmit = async (e: React.FormEvent) => {
		e.preventDefault();

		if (!username.trim()) {
			toast.error("Username gak boleh kosong!");
			return;
		}

		setLoading(true);

		try {
			const res = await axiosInstance.post("/staf/forgot-password", { username });
			setForgotUsername(username);
			toast.success(res.data.message || "OTP dikirim. Minta ke admin ya!");
			setLoading(false);
		} catch (error: any) {
			const msg = error.response?.data?.message || "Gagal kirim OTP";
			toast.error(msg);
			setLoading(false);
		}finally {
			setLoading(false);
			navigate("/verify-otp");
		}
	};


	return (
		<div className="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl overflow-hidden border border-white/20 w-full">
			<div className="py-8 px-4 w-full">
				<div className="mb-8 text-center">
					<h1 className="text-2xl font-bold text-white">Lupa Password</h1>
					<p className="text-white/80 mt-1">Masukan Username Anda untuk melanjutkan</p>
				</div>

				{/* Form */}
				<form onSubmit={handleSubmit} className="space-y-6">
					<div className="space-y-6">
						{/* Username Field */}
						<div className="form-control">
							<label className="input rounded-xl input-secondary bg-transparent focus-within:bg-white/20 w-full text-white placeholder-white/50 border-white/20 focus:border-white/50 focus:bg-white/10">
								<FiUser className="text-white/70" />
								<input
									type="text"
									required
									placeholder="Username"
									value={username}
									onChange={(e) => setUsername(e.target.value)}
									pattern="[A-Za-z][A-Za-z0-9\_\-]*"
									minLength={3}
									maxLength={30}
									title="Only letters, numbers, underscore or dash allowed"
								/>
							</label>
							<p className="text-xs text-white/60 mt-1">
								Must be 3-30 characters (letters, numbers or dash)
							</p>
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
									<span>Kirim</span>
									<FaArrowRight className="ml-2 transition-transform group-hover:translate-x-1" />
								</>
							)}
						</button>
					</div>
				</form>
			</div>
		</div>
	);
};

export default ForgotPasswordPage;
