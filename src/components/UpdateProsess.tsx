import { useState, useEffect } from "react";
import { useTaskStore } from "../store/useTaskStore";
import { BsBox, BsReceipt, BsXCircle } from "react-icons/bs";
import { FaCamera, FaSpinner } from "react-icons/fa";
import { RiGalleryFill } from "react-icons/ri";
import { useNavigate } from "react-router-dom";
import { useTabStore } from "@/store/useTabsStore";
import toast from "react-hot-toast";

type FormData = {
	status_proses: string;
	bukti: string | File;
	catatan: string;
	nomor_resi: string;
};

const UpdateProsess = () => {
	const { selectedBarang, isLoadingUpdateProsess, updateProsess } = useTaskStore();
	const { setActiveTabTask } = useTabStore()
	const [messageAlert, setMessageAlert] = useState('');

	const navigate = useNavigate();

	// State form data
	const [formData, setFormData] = useState<FormData>({
		status_proses: 'diterima',
		bukti: '',
		catatan: '',
		nomor_resi: ''
	});

	// Image Url
	const imageUrl =
		typeof formData.bukti === 'string'
			? `${import.meta.env.VITE_API_URL.replace('/api', '')}/barang/bukti/${formData.nomor_resi}`
			: formData.bukti instanceof File
				? URL.createObjectURL(formData.bukti)
				: null;


	// Hook component didMount
	useEffect(() => {
		if (selectedBarang) {
			setFormData({
				status_proses: selectedBarang.status_proses || 'diterima',
				bukti: selectedBarang.bukti || '',
				catatan: selectedBarang.catatan || '',
				nomor_resi: selectedBarang.nomor_resi || ''
			});
		}
	}, [selectedBarang]);

	// Handle Change Input
	const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
		const { name, value } = e.target;
		setFormData(prev => ({
			...prev,
			[name]: value
		}));
		setMessageAlert('');
	};

	const isEqualFormData = (form: typeof formData, selected: typeof selectedBarang) => {
		const normalize = (val: any) => (val == null ? "" : val);
		return (
			normalize(form.status_proses) === normalize(selected?.status_proses) &&
			normalize(form.catatan) === normalize(selected?.catatan) &&
			normalize(form.nomor_resi) === normalize(selected?.nomor_resi) &&
			(
				(typeof form.bukti === "string" && normalize(form.bukti) === normalize(selected?.bukti)) ||
				(form.bukti instanceof File)
			)
		);
	};


	// Handle Submit
	const handleSubmit = async (e: React.FormEvent) => {
		e.preventDefault();

		// Reset message alert dulu
		setMessageAlert("");

		// Cek apakah ada perubahan
		if (isEqualFormData(formData, selectedBarang)) {
			setMessageAlert("Tidak ada perubahan yang dilakukan.");
			return;
		}

		if (
			formData.status_proses === "diterima" &&
			(!formData.bukti || typeof formData.bukti === "string")
		) {
			setMessageAlert("Upload ulang bukti terlebih dahulu.");
			return;
		}

		// Validasi tipe file bukti
		if (formData.bukti instanceof File) {
			const allowedTypes = [
				"image/jpeg",
				"image/png",
				"image/jpg",
				"image/webp",
				"image/heic",
				"image/avif"
			];
			if (!allowedTypes.includes(formData.bukti.type)) {
				setMessageAlert("Bukti harus berupa gambar (jpeg, jpg, png, webp, heic, avif).");
				return;
			}
		}

		const data = new FormData();
		data.append("_method", "PUT");

		if (selectedBarang?.id) {
			data.append("id_barang", String(selectedBarang.id));
		}

		data.append("status_prosess", formData.status_proses);
		data.append("catatan", formData.catatan || "");

		if (formData.bukti instanceof File) {
			data.append("bukti", formData.bukti);
		}

		if (formData.nomor_resi) {
			data.append("nomor_resi", formData.nomor_resi);
		}

		try {
			await updateProsess(data);
			document.getElementById("close-modal")?.click();
			if (window.location.pathname === "/detail") {
				navigate("/");
			}
			setActiveTabTask(formData.status_proses as "diproses" | "diantar" | "diterima");
			toast.success("Update proses barang berhasil.");
		} catch (error: any) {
			setMessageAlert(
				error?.message || "Terjadi kesalahan saat update proses."
			);
		}
	};


	return (
		<dialog id="modal-update-prosess" className="modal modal-bottom sm:modal-middle mt-0">
			<div className={`modal-box h-[100vh] p-0`}>
				<div className={`sticky top-0 bg-base-100 z-[101] shadow-md p-3`}>
					<h2 className="card-title mb-4 z-50">Update Proses</h2>
					{messageAlert && (
						<div role="alert" className="alert alert-error alert-soft flex justify-between ">
							<span>{messageAlert}</span>
							<button onClick={() => setMessageAlert('')}><BsXCircle size={20} /></button>
						</div>
					)}
				</div>

				{/* Form Start */}
				<form onSubmit={handleSubmit} className={`px-3 overflow-y-scroll pt-5 pb-10 transition-all duration-300 z-[100]`}>

					{/* Item Info */}
					<div className="mb-6 bg-base-200 rounded-lg p-3">
						<div className="flex items-center gap-3 mb-2">
							<BsBox className="text-primary" size={20} />
							<span className="font-medium">{selectedBarang?.nama_barang}</span>
						</div>
						<div className="flex items-center gap-3">
							<BsReceipt className="text-primary" size={20} />
							<span className="text-sm">Resi: {selectedBarang?.nomor_resi}</span>
						</div>
					</div>

					{/* Status Proses */}
					<div className="form-control mb-5">
						<label className="label mb-2 border-b w-full">
							<span className="label-text">Status Proses</span>
						</label>
						<div className="flex gap-3 items-center justify-center">
							{['diproses', 'diantar', 'diterima'].map((status) => (
								<label key={status} className="label cursor-pointer justify-start gap-3">
									<input
										type="radio"
										name="status_proses"
										value={status}
										checked={formData.status_proses === status}
										onChange={handleChange}
										className="radio radio-primary"
										disabled={isLoadingUpdateProsess}
									/>
									<span className="label-text capitalize">{status}</span>
								</label>
							))}
						</div>
					</div>

					{formData.status_proses === 'diterima' && (
						<div className="form-control mb-5">
							<label className="label border-b w-full mb-2">
								<span className="label-text">Upload Bukti</span>
							</label>

							{!formData.bukti ? (
								<div className="flex items-center gap-3">
									{/* Gallery button */}
									<button
										type="button"
										className="btn btn-circle btn-lg btn-primary"
										onClick={() => {
											const input = document.createElement('input');
											input.type = 'file';
											input.accept = 'image/*';
											input.onchange = (e: Event) => {
												const target = e.target as HTMLInputElement;
												const file = target.files?.[0] || null;
												if (file) {
													setFormData(prev => ({ ...prev, bukti: file }));
													setMessageAlert('')
												}
											};
											input.click();
										}}
									>
										<RiGalleryFill size={20} />
									</button>

									{/* Camera button */}
									<button
										type="button"
										className="btn btn-circle btn-lg btn-secondary"
										onClick={() => {
											const input = document.createElement('input');
											input.type = 'file';
											input.accept = 'image/*';
											input.capture = 'environment';
											input.onchange = (e: Event) => {
												const target = e.target as HTMLInputElement;
												const file = target.files?.[0] || null;
												if (file) {
													setFormData(prev => ({ ...prev, bukti: file }));
													setMessageAlert('')
												}
											};
											input.click();
										}}
									>
										<FaCamera size={20} />
									</button>
								</div>
							) : (
								<div className="relative w-32 h-32 mt-2">
									{imageUrl && (
										<img
											src={imageUrl}
											alt="Preview"
											className="w-full h-full object-cover rounded-lg border"
										/>
									)}
									<button
										type="button"
										onClick={() => setFormData(prev => ({ ...prev, bukti: "" }))}
										className="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center shadow-md -translate-y-1/2 translate-x-1/2"
									>
										✕
									</button>
								</div>
							)}


						</div>
					)}


					{/* Catatan */}
					<div className="form-control mb-6">
						<label className="label">
							<span className="label-text">Catatan</span>
						</label>
						<textarea
							name="catatan"
							value={formData.catatan}
							onChange={handleChange}
							className="textarea textarea-bordered h-24"
							placeholder="Tambah catatan jika perlu..."
							disabled={isLoadingUpdateProsess}
						></textarea>
					</div>

					{/* Action Buttons */}
					<div className="flex justify-between">
						<button className="btn" onClick={() => document.getElementById('close-modal')?.click()} role="button" type="button">Batal</button>
						<button type="submit" className="btn btn-primary" disabled={isLoadingUpdateProsess}>
							Simpan Perubahan
							{isLoadingUpdateProsess && <FaSpinner className="w-4 h-4 ml-2 animate-spin" />}
						</button>
					</div>
				</form>

			</div>
			<form method="dialog" className="modal-backdrop">
				<button id="close-modal"></button>
			</form>
		</dialog>
	);
};

export default UpdateProsess;
