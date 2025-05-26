import Footer from "./Footer"
import logo from "@/assets/logo-placeholder.svg";

const SplashScreen = ({message} : {message?: string}) => {
	return (
		<div className="flex flex-col items-center justify-center h-screen">
			<div className="flex items-center justify-start gap-2 animate-bounce">
				<img
					src={logo}
					alt="Logo"
					className="w-22"
					draggable="false"
				/>
				<span className="text-3xl font-semibold text-primary animate-flip-in-y animate-infinite animate-duration-1000 animate-delay-150 animate-ease-in-out">AntarAje</span>
			</div>
			<p className="text-center italic text-gray-500">
				{message}
			</p>
			<div className="bottom-0 absolute py-4">
				<Footer />
			</div>
		</div>
	)
}

export default SplashScreen
