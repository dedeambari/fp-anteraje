import { useState } from "react";
import { useAuthStore } from "@/store/useAuthStore";
import { BsPerson, BsPhone, BsKey, BsImage } from "react-icons/bs";
import { FaMotorcycle, FaCar, FaSpinner, FaUser } from "react-icons/fa";
import type { Staf } from "@/types";
import { RiLogoutCircleRLine } from "react-icons/ri";
import Footer from "@/components/Footer";
import toast from "react-hot-toast";
import { FiEye, FiEyeOff } from "react-icons/fi";


interface FormData {
	nama: string;
	no_hp: string;
	transportasi: string;
	old_password: string;
	new_password: string;
	new_password_confirmation: string;
	profile: File | null;
}

const ProfilePage = () => {
	const { authUser, logout, updateProfile } = useAuthStore();
	const user = authUser?.staf as Staf;

	const [formData, setFormData] = useState<FormData>({
		nama: user?.nama || "",
		no_hp: user?.no_hp || "",
		transportasi: user?.transportasi || "motor",
		old_password: "",
		new_password: "",
		new_password_confirmation: "",
		profile: null
	});

	const imageProfile = import.meta.env.VITE_API_URL.replace('/api', '') + "/storage/" + user?.profile;
	const [previewImage, setPreviewImage] = useState(user?.profile ? imageProfile : null);
	const [errors, setErrors] = useState<{ [key: string]: string }>({});
	const [isSubmitting, setIsSubmitting] = useState(false);

	const [showPassword, setShowPassword] = useState({
		old: false,
		new: false,
		confirm: false
	});

	const togglePassword = (field: keyof typeof showPassword) => {
		setShowPassword(prev => ({ ...prev, [field]: !prev[field] }));
	};

	const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
		const { name, value } = e.target;
		setFormData(prev => ({ ...prev, [name]: value }));
	};

	const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
		const file = e.target.files?.[0];
		if (file) {
			setFormData(prev => ({ ...prev, profile: file }));
			setPreviewImage(URL.createObjectURL(file));
		}
	};

	const handleSubmit = async (e: React.FormEvent) => {
		e.preventDefault();
		setIsSubmitting(true);

		const isSame =
			formData.nama === user?.nama &&
			formData.no_hp === user.no_hp &&
			formData.transportasi === user.transportasi &&
			!formData.old_password &&
			!formData.new_password &&
			!formData.new_password_confirmation &&
			!formData.profile;

		if (isSame) {
			toast.error("Tidak ada perubahan.");
			setIsSubmitting(false);
			return;
		}

		const dataForm = new FormData();
		dataForm.append("_method", "PUT");
		dataForm.append("nama", formData.nama);
		dataForm.append("no_hp", formData.no_hp);
		dataForm.append("transportasi", formData.transportasi);
		if (formData.old_password || formData.new_password || formData.new_password_confirmation) {
			dataForm.append("old_password", formData.old_password);
			dataForm.append("new_password", formData.new_password);
			dataForm.append("new_password_confirmation", formData.new_password_confirmation);
		}
		if (formData.profile) {
			dataForm.append("profile", formData.profile);
		}

		try {
			await updateProfile(dataForm);
			setFormData(prev => ({
				...prev,
				old_password: "",
				new_password: "",
				new_password_confirmation: "",
			}));
		} catch (error: any) {
			if (error.response?.data?.errors) {
				setErrors(error.response.data.errors);
			} else {
				toast.error("Terjadi kesalahan saat mengupdate profil.");
			}
		} finally {
			setIsSubmitting(false);
		}
	};


	return (
		<div className="overflow-hidden">
			<div className="container mx-auto px-2 pb-14 h-[calc(100vh-140px)] overflow-auto">
				{/* Profile Header with Gradient Background */}
				<div className="z-10 mt-4 shadow  relative bg-gradient-to-r from-primary to-secondary rounded-3xl pt-13 pb-8 px-6 mb-8 overflow-hidden">
					<div className="absolute inset-0 opacity-10 pattern-dots pattern-white pattern-size-4" />
					<div className="relative z-10 flex flex-col items-center text-center text-white">
						{/* Profile Picture with Floating Edit Button */}
						<div className="relative group mb-4">
							<div className="avatar">
								<div className="w-32 rounded-full border-4 border-white/20 shadow-lg transition-all duration-300 group-hover:border-white/40">
									{previewImage ? (
										<img src={previewImage} alt="Profile" className="object-cover" />
									) : (
										<div className="bg-white/20 w-full h-full flex items-center justify-center text-5xl font-bold">
											{user?.nama?.charAt(0) || "U"}
										</div>
									)}
								</div>
							</div>
							<label className="absolute bottom-0 right-0 bg-white text-primary p-3 rounded-full shadow-md cursor-pointer transition-all hover:scale-110">
								<BsImage size={18} />
								<input
									type="file"
									className="hidden"
									accept="image/jpeg,image/jpg,image/png"
									onChange={handleFileChange}
								/>
							</label>
						</div>

						<h2 className="text-2xl font-bold mb-1">{formData.nama || 'Nama Pengguna'}</h2>
						<p className="text-white/80 flex items-center gap-1">
							<BsPhone size={14} /> {formData.no_hp || '08xxxxxxxxxx'}
						</p>
						<div className="flex items-center mt-2">
							<div className="badge badge-accent font-semibold badge-soft font-mono">
								<FaUser size={12} /> {user.username}
							</div>
							<div className="divider divider-horizontal divider-neutral mx-0"></div>
							<div className="badge badge-white/10 border-white/20 gap-1">
								{formData.transportasi === 'motor' ? (
									<><FaMotorcycle size={14} /> Motor</>
								) : (
									<><FaCar size={14} /> Mobil</>
								)}
							</div>
						</div>
					</div>
				</div>

				{/* Profile Form with Card Layout */}
				<div className="space-y-6 -mt-14 -z-1 pb-10">
					<div className="card bg-white shadow-xl rounded-b-2xl overflow-hidden pt-5">
						<div className="card-body p-6">
							<h3 className="font-bold text-lg flex items-center gap-2 mb-4 text-gray-700">
								<BsPerson className="text-primary" /> Informasi Profil
							</h3>

							<form onSubmit={handleSubmit} className="space-y-5">
								{/* Nama */}
								<div className="form-control flex flex-col w-full">
									<label className="label">
										<span className="label-text text-gray-500 w">Nama Lengkap</span>
									</label>
									<input
										type="text"
										name="nama"
										value={formData.nama}
										onChange={handleChange}
										className={`input input-bordered ${errors.nama ? 'input-error' : 'input-primary'} w-full`}
										placeholder="Masukkan nama lengkap"
									/>
									{errors.nama && <span className="text-error text-xs mt-1">{errors.nama[0]}</span>}
								</div>

								{/* No HP */}
								<div className="form-control flex flex-col w-full">
									<label className="label">
										<span className="label-text text-gray-500">Nomor HP</span>
									</label>
									<input
										type="tel"
										name="no_hp"
										value={formData.no_hp}
										onChange={handleChange}
										className={`input input-bordered ${errors.no_hp ? 'input-error' : 'input-primary'} w-full`}
										placeholder="Masukkan nomor HP"
									/>
									{errors.no_hp && <span className="text-error text-xs mt-1">{errors.no_hp[0]}</span>}
								</div>

								{/* Transportasi */}
								<div className="form-control">
									<label className="label">
										<span className="label-text text-gray-500">Jenis Transportasi</span>
									</label>
									<div className="flex gap-4">
										<label className={`flex-1 flex flex-col items-center p-3 rounded-xl border-2 cursor-pointer transition-all ${formData.transportasi === "motor"
											? 'border-primary bg-primary/10'
											: 'border-gray-200 hover:border-primary/30'
											}`}>
											<input
												type="radio"
												name="transportasi"
												value="motor"
												checked={formData.transportasi === "motor"}
												onChange={handleChange}
												className="hidden"
											/>
											<FaMotorcycle
												size={24}
												className={`mb-2 ${formData.transportasi === "motor" ? 'text-primary' : 'text-gray-400'
													}`}
											/>
											<span className={`font-medium ${formData.transportasi === "motor" ? 'text-primary' : 'text-gray-500'
												}`}>
												Motor
											</span>
										</label>
										<label className={`flex-1 flex flex-col items-center p-3 rounded-xl border-2 cursor-pointer transition-all ${formData.transportasi === "mobil"
											? 'border-primary bg-primary/10'
											: 'border-gray-200 hover:border-primary/30'
											}`}>
											<input
												type="radio"
												name="transportasi"
												value="mobil"
												checked={formData.transportasi === "mobil"}
												onChange={handleChange}
												className="hidden"
											/>
											<FaCar
												size={24}
												className={`mb-2 ${formData.transportasi === "mobil" ? 'text-primary' : 'text-gray-400'
													}`} />
											<span className={`font-medium ${formData.transportasi === "mobil" ? 'text-primary' : 'text-gray-500'
												}`}>Mobil</span>
										</label>
									</div>
									{errors.transportasi && <span className="text-error text-xs mt-1">{errors.transportasi[0]}</span>}
								</div>
							</form>
						</div>
					</div>

					{/* Password Section */}
					<div className="collapse collapse-plus bg-white shadow-xl rounded-2xl px-2">
						<input type="checkbox" className="peer" />
						<div className="collapse-title font-bold text-lg flex items-center gap-2 px-2 text-gray-700 peer-checked:text-primary">
							<BsKey className="text-primary" /> Ubah Password
						</div>
						<div className="collapse-content px-0 space-y-5">
							<div className="card">
								<div className="card-body px-4">

									{/* Old Password */}
									<div className="form-control flex flex-col w-full mb-4">
										<label className="label-text text-gray-500">Password Lama</label>
										<label className={`input input-bordered w-full pr-10 ${errors.old_password ? 'input-error' : 'input-primary'}`}>
											<input
												type={showPassword.old ? "text" : "password"}
												name="old_password"
												value={formData.old_password}
												onChange={handleChange}
												placeholder="Masukkan password lama"
											/>
											<button
												type="button"
												className="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer"
												onClick={() => togglePassword('old')}
											>
												{showPassword.old ? <FiEye /> : <FiEyeOff />}
											</button>
										</label>
										{errors.old_password && (
											<span className="text-error text-xs mt-1">{errors.old_password[0]}</span>
										)}
									</div>

									{/* New Password */}
									<div className="form-control flex flex-col w-full mb-4">
										<label className="label-text text-gray-500">Password Baru</label>
										<label className={`input input-bordered w-full pr-10 ${errors.new_password ? 'input-error' : 'input-primary'}`}>
											<input
												type={showPassword.new ? "text" : "password"}
												name="new_password"
												value={formData.new_password}
												onChange={handleChange}
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
										{errors.new_password && (
											<span className="text-error text-xs mt-1">{errors.new_password[0]}</span>
										)}
									</div>

									{/* Confirm Password */}
									<div className="form-control flex flex-col w-full mb-4">
										<label className="label-text text-gray-500">Konfirmasi Password Baru</label>
										<label className={`input input-bordered w-full pr-10 ${errors.new_password ? 'input-error' : 'input-primary'}`}>
											<input
												type={showPassword.confirm ? "text" : "password"}
												name="new_password_confirmation"
												value={formData.new_password_confirmation}
												onChange={handleChange}
												placeholder="Konfirmasi password baru"
											/>
											<button
												type="button"
												className="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer"
												onClick={() => togglePassword('confirm')}
											>
												{showPassword.confirm ? <FiEye /> : <FiEyeOff />}
											</button>
											{errors.new_password_confirmation && (
												<span className="text-error text-xs mt-1">{errors.new_password_confirmation[0]}</span>
											)}
										</label>
									</div>

								</div>
							</div>
						</div>

					</div>

					{/* Action Buttons */}
					<div className="flex flex-col gap-3 mt-6 z-10">
						<button
							type="submit"
							className={`btn btn-primary rounded-xl shadow-lg`}
							disabled={isSubmitting}
							onClick={handleSubmit}
						>
							{isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'}
							{isSubmitting && <FaSpinner className="w-4 h-4 ml-2 animate-spin" />}

						</button>

						<button
							type="button"
							onClick={logout}
							className="btn btn-outline btn-error rounded-xl gap-2"
						>
							<RiLogoutCircleRLine />
							Logout
						</button>
					</div>
				</div>
				<Footer />
			</div>
		</div>
	);
};

export default ProfilePage;