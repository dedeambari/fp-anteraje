import { useState } from 'react';
import { useAuthStore } from '@/store/useAuthStore';
import { LoaderIcon } from 'react-hot-toast';
import { FiEye, FiEyeOff, FiLock, FiUser, FiArrowRight } from 'react-icons/fi';
import { Link } from 'react-router-dom';

const LoginPage = () => {
	const [showPassword, setShowPassword] = useState(false);
	const [formData, setFormData] = useState({
		username: "",
		password: ""
	});
	const { login, isLoggingIn } = useAuthStore();

	const handleSubmit = async (e: React.FormEvent) => {
		e.preventDefault();
		login(formData);
	};

	return (
		<div className="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl overflow-hidden border border-white/20 w-full">
			<div className="py-8 px-4 w-full">
				<div className="mb-8 text-center">
					<h1 className="text-2xl font-bold text-white">Welcome Back</h1>
					<p className="text-white/80 mt-1">Sign in to your account</p>
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
									value={formData.username}
									onChange={(e) => setFormData({ ...formData, username: e.target.value })}
									pattern="[A-Za-z][A-Za-z0-9\-]*"
									minLength={3}
									maxLength={30}
									title="Only letters, numbers or dash"
								/>
							</label>
							<p className="text-xs text-white/60 mt-1">
								Must be 3-30 characters (letters, numbers or dash)
							</p>
						</div>

						{/* Password Field */}
						<div className="form-control">
							<label className="input rounded-xl input-secondary bg-transparent focus-within:bg-white/20 w-full text-white placeholder-white/50 border-white/20 focus:border-white/50 focus:bg-white/10">
								<FiLock className="text-white/70" />
								{/* </div> */}
								<input
									type={showPassword ? "text" : "password"}
									required
									placeholder="Password"
									value={formData.password}
									onChange={(e) => setFormData({ ...formData, password: e.target.value })}
									minLength={8}
									maxLength={30}
								/>
								<button
									type="button"
									onClick={() => setShowPassword(!showPassword)}
									className="absolute inset-y-0 right-0 pr-3 flex items-center text-white/70 hover:text-white"
								>
									{showPassword ? <FiEyeOff /> : <FiEye />}
								</button>
							</label>
							<p className="text-xs text-white/60 mt-1">
								Must be 8-30 characters
							</p>
						</div>
					</div>

					{/* Submit Button */}
					<button
						type="submit"
						className="btn btn-secondary text-white w-full mt-6 group"
						disabled={isLoggingIn}
					>
						{isLoggingIn ? (
							<>
								<LoaderIcon className="h-5 w-5 animate-spin" />
								<span className="ml-2">Signing in...</span>
							</>
						) : (
							<>
								<span>Sign in</span>
								<FiArrowRight className="ml-2 transition-transform group-hover:translate-x-1" />
							</>
						)}
					</button>
				</form>

				{/* Forgot Password */}
				<div className="mt-4 text-center">
					<Link
						to="/forgot-password"
						className="text-sm text-white/70 hover:text-white transition-colors"
					>
						Lupa Password?
					</Link>
				</div>
			</div>
		</div>
	);
};

export default LoginPage;