import { useId } from "react";
import { VscChromeClose } from "react-icons/vsc";
export function BuktiPreview({ nomorResi, image }: { nomorResi: string; image?: string }) {
	const modalId = useId();
	const imageUrl = image
		? `${import.meta.env.VITE_API_URL.replace("/api", "")}/storage/${image}`
		: `${import.meta.env.VITE_API_URL.replace("/api", "")}/barang/bukti/${nomorResi}`;

	return (
		<div>
			{/* Kotak Gambar */}
			<div
				className="relative w-28 h-28 bg-gray-200 rounded-md overflow-hidden cursor-pointer group"
				onClick={() => {
					const modal = document.getElementById(modalId) as HTMLDialogElement;
					if (modal) modal.showModal();
				}}
			>
				<img src={imageUrl} alt="bukti" className="object-cover w-full h-full" />

				{/* Overlay saat hover */}
				<div className="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
					<span className="text-white text-xs font-medium">Bukti Diterima</span>
				</div>
			</div>

			{/* Modal pakai <dialog> */}
			<dialog id={modalId} className="modal">
				<div className="modal-box">
					<img
						src={imageUrl}
						alt="bukti full"
						className="max-w-[80vw] max-h-[60vh] object-contain mx-auto"
					/>
				</div>
				<form method="dialog" className="modal-backdrop">
					<div className="absolute bottom-14 flex items-center w-full font-bold justify-center transition-all duration-200 ease-in-out">
						<button className="btn btn-lg btn-error btn-circle">
							<VscChromeClose size={20} className="text-white" />
						</button>
					</div>
					{/* <button>close</button> */}
				</form>
			</dialog>
		</div>
	);
}
