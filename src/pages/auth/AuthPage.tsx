import Footer from "@/components/Footer"
import ForgotPasswordPage from "@/pages/auth/ForgotPasswordPage"
import LoginPage from "@/pages/auth/LoginPage"
import ResetPasswordPage from "@/pages/auth/ResetPasswordPage"
import VerifyOtpPage from "@/pages/auth/VerifyOtpPage"
// import { useLocation } from "react-router-dom"

const AuthPage = ({ typeAuth }: { typeAuth: string }) => {


	return (
		<div className="min-h-screen screen flex flex-col items-center justify-start px-3 pt-16 relative">

			{/* Main Content */}
			<div className="w-full max-w-md">
				{/* Logo */}
				<div className='flex justify-center items-center gap-3 mb-8'>
					<img
						src="/logo.svg"
						alt="Logo"
						draggable="false"
						className='w-22  filter drop-shadow-lg'
					/>
					<label className='text-4xl font-bold text-white drop-shadow-lg label-text pointer-events-none'>AntarAje</label>
				</div>

				{typeAuth === "login" && <LoginPage />}
				{typeAuth === "forgot-password" && <ForgotPasswordPage />}
				{typeAuth === "verify-otp" && <VerifyOtpPage />}
				{typeAuth === "reset-password" && <ResetPasswordPage />}


			</div>
			<div className='absolute bottom-0 w-full py-6'>
				<Footer />
			</div>
		</div>
	)
}

export default AuthPage
