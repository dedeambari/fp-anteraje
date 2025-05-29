import { useEffect } from "react";
import { useTaskStore } from "@/store/useTaskStore";
import { useNavigate } from "react-router-dom";
import { useTabStore } from "@/store/useTabsStore";
import {
	BsArrowLeft,
	BsBox,
	BsClock,
	BsCashCoin,
	BsPerson,
	BsGeoAlt,
	BsPhone,
	BsReceipt,
	BsTag,
	BsCamera,
	BsTruck
} from "react-icons/bs";
import type { DetailBarangData, ResponseTask } from "@/types";
import { formatDate, getBadgeColor } from "@/utils/helper";
import { BuktiPreview } from "@/components/BuktiPreview";
import { motion } from "framer-motion"
import Footer from "@/components/Footer";
import Header from "@/components/Header";

const DetailBarangPage = () => {
	const {
		data: dataTask,
		setSelectedBarang,
		dataDetailBarang
	} = useTaskStore();
	const { setActiveTab, activeTabTask } = useTabStore();
	const navigate = useNavigate();

	useEffect(() => {
		if (!dataDetailBarang) {
			navigate("/");
		}
	}, [dataDetailBarang, navigate, setActiveTab]);

	const handleBack = () => {
		navigate("/");
	};

	if (!dataDetailBarang) return null;

	const {
		pemrosessan,
		barang,
		kategori,
		payment,
		pengirim,
		penerima,
		history
	} = dataDetailBarang.data as DetailBarangData;

	const { data } = dataTask as ResponseTask;

	const handleUpdateProsess = (id_barang: number) => {

		// Ambil data dari tab sekarang
		const dataUpdate = data?.[activeTabTask].find(item => item.id === id_barang);
		if (!dataUpdate) return;

		setSelectedBarang({
			...dataUpdate,
			catatan: pemrosessan.catatan
		});

		// Buka modal
		const modal = document.getElementById("modal-update-prosess") as HTMLDialogElement;
		modal?.showModal();
	};


	const getProgressColor = (status: string) => {
		switch (status.toLowerCase()) {
			case "diterima":
				return "bg-success";
			case "diproses":
				return "bg-warning";
			case "diantar":
				return "bg-info";
			default:
				return "ghost";
		}
	};

	return (
		<motion.div
			className="container mx-auto max-w-md"
			initial={{ y: 100, opacity: 0 }}
			animate={{ y: 0, opacity: 1 }}
			exit={{ y: 100, opacity: 0 }}
			transition={{ duration: 0.2, ease: "easeOut" }}
		>
			<Header>
				<button className="px-1" onClick={handleBack}>
					<BsArrowLeft className="text-xl font-normal" />
				</button>
				<h1 className="text-xl font-semibold py-4">Detail Barang</h1>
			</Header>

			<div className="px-4 pb-20">
				{/* Status Card */}
				<div className="card bg-base-100 shadow-md mt-4">
					<div className="card-body p-4">
						<div className="flex justify-between">
							<span className="text-lg font-semibold">Status: </span>
							<span className={` capitalize badge ${getBadgeColor(pemrosessan.status_proses)
								}`}>
								{pemrosessan.status_proses}
							</span>
						</div>
						<div className="flex items-center gap-2">
							<BsBox className="text-primary w-5" size={20} />
							<h2 className="card-title text-lg capitalize">
								{barang.nama_barang}
							</h2>

						</div>

						<div className="mt-2">
							<div className="flex items-center gap-2 text-sm">
								<BsReceipt className="opacity-70 w-5" />
								<span>Resi: {barang.nomor_resi}</span>
							</div>
							<div className="flex items-center gap-2 text-sm mt-1">
								<BsClock className="opacity-70 w-5" />
								<span>Estimasi: {formatDate(pemrosessan.estimasi_waktu)}</span>
							</div>
						</div>
					</div>
				</div>

				{/* Item Details */}
				<div className="card bg-base-100 shadow-md mt-4">
					<div className="card-body p-4">
						<h3 className="font-semibold flex items-center gap-2">
							<BsTag className="text-primary w-5" /> Detail Barang
						</h3>
						<div className="divider my-1"></div>

						<div className="grid grid-cols-2 gap-2 text-sm">
							<div>
								<p className="text-gray-500">Deskripsi:</p>
								<p>{barang.deskripsi_barang}</p>
							</div>
							<div>
								<p className="text-gray-500">Kategori:</p>
								<p>{kategori.nama_kategori}</p>
							</div>
							{barang.berat && (
								<div>
									<p className="text-gray-500">Berat:</p>
									<p>{barang.berat} kg</p>
								</div>
							)}
							{barang.volume && (
								<div>
									<p className="text-gray-500">Volume:</p>
									<p>{barang.volume} m³</p>
								</div>
							)}
						</div>
					</div>
				</div>

				{/* Payment Info */}
				<div className="card bg-base-100 shadow-md mt-4">
					<div className="card-body p-4">
						<h3 className="font-semibold flex items-center gap-2">
							<BsCashCoin className="text-primary w-5" />
							Pembayaran
						</h3>
						<div className="divider my-1"></div>

						<div className="text-sm">
							<div className="flex justify-between">
								<span className="text-gray-500">Status:</span>
								<span className={`capitalize badge ${payment.status === "sudah_bayar" ? "badge-accent" : "badge-error"}`}>
									{payment.status.replace('_', ' ')}
								</span>
							</div>
							<div className="flex justify-between mt-1">
								<span className="text-gray-500">Dibayar oleh:</span>
								<span className="capitalize">{payment.pays}</span>
							</div>
							<div className="flex justify-between mt-1">
								<span className="text-gray-500">Total Tarif:</span>
								<span>Rp {parseInt(barang.total_tarif).toLocaleString('id-ID')}</span>
							</div>
						</div>
					</div>
				</div>

				{/* Sender & Receiver */}
				<div className="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
					<div className="card bg-base-100 shadow-md">
						<div className="card-body p-4">
							<h3 className="font-semibold flex items-center gap-2">
								<BsPerson className="text-primary w-5" /> Pengirim
							</h3>
							<div className="divider my-1"></div>

							<div className="text-sm space-y-1">
								<p className="font-medium">{pengirim.nama}</p>
								<div className="flex items-start gap-2">
									<BsGeoAlt className="mt-0.5 opacity-70 w-5" />
									<p>{pengirim.alamat}</p>
								</div>
								<div className="flex items-center gap-2">
									<BsPhone className="opacity-70" />
									<p>{pengirim.no_hp}</p>
								</div>
							</div>
						</div>
					</div>

					<div className="card bg-base-100 shadow-md">
						<div className="card-body p-4">
							<h3 className="font-semibold flex items-center gap-2">
								<BsPerson className="text-primary w-5" /> Penerima
							</h3>
							<div className="divider my-1"></div>

							<div className="text-sm space-y-1">
								<p className="font-medium">{penerima.nama}</p>
								<div className="flex items-start gap-2">
									<BsGeoAlt className="mt-0.5 opacity-70 w-5" />
									<p>{penerima.alamat}</p>
								</div>
								<div className="flex items-center gap-2">
									<BsPhone className="opacity-70 w-5" />
									<p>{penerima.no_hp}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				{/* Evidence & Notes */}
				{pemrosessan.bukti && (
					<div className="card bg-base-100 shadow-md mt-4">
						<div className="card-body p-4">
							<h3 className="font-semibold flex items-center gap-2">
								<BsCamera className="text-primary w-5" /> Bukti
							</h3>
							<div className="divider my-1"></div>

							<BuktiPreview nomorResi={barang.nomor_resi} image={pemrosessan.bukti} />
						</div>
					</div>
				)}

				{/* History */}
				<div className="card bg-base-100 shadow-md mt-4">
					<div className="card-body p-4">
						<h3 className="font-semibold flex items-center gap-2">
							<BsTruck className="text-primary w-5" /> Riwayat Proses
						</h3>
						<div className="divider my-1"></div>

						<div className="space-y-4">
							{history.map((item, index) => (
								<div key={index} className="flex gap-3">
									<div className="flex flex-col items-center">
										<div className={`w-3 h-3 rounded-full ${getProgressColor(item.status_proses)}`
										}>
										</div>
										{index < history.length - 1 && (
											<div className="w-px h-full bg-gray-300"></div>
										)}
									</div>
									<div className="flex-1 pb-4">
										<div className="flex justify-between">
											<span className="font-medium capitalize">{item.status_proses}</span>
											<span className="text-sm text-gray-500">
												{new Date(item.created_at).toLocaleDateString('id-ID')}
											</span>
										</div>
										{item.catatan && (
											<div className="mt-1 text-sm bg-base-200 p-2 rounded">
												<p className="italic">"{item.catatan}"</p>
											</div>
										)}
									</div>
								</div>
							))}
						</div>
					</div>
				</div>

				{/* Buttons */}
				<div className="mt-5 flex gap-2 justify-end">
					<button className="btn btn-accent" onClick={() => handleUpdateProsess(barang.id)}>Update Prosess</button>
				</div>
			</div>
			<Footer />
		</motion.div>
	);
};

export default DetailBarangPage;