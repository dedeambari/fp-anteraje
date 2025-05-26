import Footer from "@/components/Footer";
import { formatDate, formatNumber, getBadgeColor } from "@/utils/helper";
import { BuktiPreview } from "@/components/BuktiPreview";
import { RiCheckboxMultipleFill } from "react-icons/ri";
import { GoTasklist } from "react-icons/go";
import { useHomeStore } from "@/store/useHomeStore";
import { useNavigate } from "react-router-dom";
import { useTaskStore } from "@/store/useTaskStore";
import toast from "react-hot-toast";
import { FaSpinner } from "react-icons/fa";

const HomePage = () => {
	const { data } = useHomeStore();
	const { fetchDetailBarang, isLoadingDetailBarang } = useTaskStore();
	const navigate = useNavigate();

	const handleShowDetail = async (id_barang: number) => {
		try {
			await fetchDetailBarang?.(id_barang);
			navigate("/detail");
		} catch (error: any) {
			toast.error("Gagal menampilkan detail barang " + error.message);
		}
	};

	return (
		<div className="overflow-hidden">
			<div className="container mx-auto h-[calc(100vh-150px)] overflow-y-auto scroll-smooth">
				{/* Ringkasan Statistik */}
				<div className="px-2 grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
					<div className="stats shadow-md bg-base-100">
						<div className="stat px-4">
							<div className="stat-title">Sisa Tugas</div>
							{formatNumber(data?.data?.sisa_jumlah_tugas || 0) === null ? (
								<span className="text-xs py-3.5 text-center italic font-normal text-gray-400 capitalize">
									"Tugas Habis"
								</span>
							) : (
								<div className="stat-value text-primary">
									{formatNumber(data?.data?.sisa_jumlah_tugas || 0)}
								</div>
							)}
							<div className="stat-desc">Tugas yang tersisa</div>
						</div>
					</div>
					<div className="stats shadow-md bg-base-100">
						<div className="stat px-4">
							<div className="stat-title">Total Barang</div>
							{formatNumber(data?.data?.total_barang || 0) === null ? (
								<span className="text-xs py-3.5 text-center italic font-normal text-gray-400 capitalize">
									"Belum ada barang"
								</span>
							) : (
								<div className="stat-value text-secondary">
									{formatNumber(data?.data?.total_barang || 0)}
								</div>
							)}
							<div className="stat-desc">Total barang tugas</div>
						</div>
					</div>
					<div className="stats shadow-md bg-base-100">
						<div className="stat px-4">
							<div className="stat-title">Barang Success</div>
							{formatNumber(data?.data.total_barang_diterima || 0) === null ? (
								<span className="text-xs py-3.5 text-center italic font-normal text-gray-400 capitalize">
									"Belum ada barang selesai"
								</span>
							) : (
								<div className="stat-value text-success">
									{formatNumber(data?.data.total_barang_diterima || 0)}
								</div>
							)}
							<div className="stat-desc">Tugas Barang selesai</div>
						</div>
					</div>
					<div className="stats shadow-md bg-base-100">
						<div className="stat px-4">
							<div className="stat-title">Barang Pending</div>
							{formatNumber(data?.data.total_barang_diantar || 0) === null ? (
								<span className="text-xs py-3.5 text-center italic font-normal text-gray-400 capitalize">
									"Belum ada barang pending"
								</span>
							) : (
								<div className="stat-value text-warning">
									{formatNumber(data?.data.total_barang_diantar || 0)}
								</div>
							)}
							<div className="stat-desc">Tugas Barang diantar</div>
						</div>
					</div>
				</div>

				{/* Tugas Baru selesai */}
				<h2 className="px-2 text-lg font-semibold mt-6 mb-2 flex items-center gap-2">
					<RiCheckboxMultipleFill className="text-info w-6 h-6" />
					Tugas Baru Selesai
				</h2>
				{data?.data.tugas_baru_selesai ? (
					<div className="px-2 grid gap-4">
						<div className="card bg-base-100 shadow-md relative">
							<div className="card-body py-4 px-3 cursor-pointer">
								<div className="w-full text-right">
									<span className={`capitalize badge  ${getBadgeColor(data.data.tugas_baru_selesai.status_proses || "")}`}>{data.data.tugas_baru_selesai.status_proses || ""}</span>
								</div>
								<div className="flex justify-start items-start gap-2">
									{data.data.tugas_baru_selesai.bukti ? (
										<BuktiPreview nomorResi={data.data.tugas_baru_selesai.nomor_resi || ''} image={data.data.tugas_baru_selesai.bukti} />
									) : (
										<div className="w-28 h-28">
											<img src="https://placehold.co/300x200?text=Tidak+ada+bukti" alt="Bukti Tugas"
												className="rounded-xl w-full h-full object-cover" />
										</div>
									)}
									<div className="flex flex-col" onClick={() => handleShowDetail(data.data.tugas_baru_selesai.id_barang)}>
										<span className="card-title text-lg">NO RESI</span>
										<p className="text-[.8em] font-semibold badge badge-soft badge-info px-2">{data.data.tugas_baru_selesai.nomor_resi}</p>
										<span className="card-title text-lg flex">
											Barang
										</span>
										<p className="ml-1 font-normal">{data.data.tugas_baru_selesai.nama_barang}</p>
									</div>
								</div>
								<div className="divider my-0"></div>
								<div className="px-2" onClick={() => handleShowDetail(data.data.tugas_baru_selesai.id_barang)}>
									<p className="text-sm opacity-75">🕒 {formatDate(data.data.tugas_baru_selesai.updated_at || "")}</p>
									<p className="mt-2 text-sm">Catatan: {data.data.tugas_baru_selesai.catatan || ""}</p>
								</div>
							</div>
							{isLoadingDetailBarang === data.data.tugas_baru_selesai.id_barang && (
								<div className="absolute top-0 left-0 w-full h-full flex justify-center items-center bg-base-200/70">
									<FaSpinner className="w-4 h-4 ml-2 animate-spin" />
								</div>
							)}
						</div>
					</div>
				) : (
					<p className="px-2 text-sm text-gray-500">Tidak ada tugas yang baru selesai.</p>
				)}

				{/* Tugas Berikutnya */}
				<div className="px-2 mt-8">
					<h2 className="text-xl font-bold mb-4 flex items-center gap-2">
						<GoTasklist className="text-secondary w-6 h-6" />
						Tugas Berikutnya
					</h2>
					<div className="space-y-4">
						{data?.data.tugas_berikutnya.map((item, idx) => (
							<div key={idx} className="card bg-base-100 shadow-md cursor-pointer" onClick={() => handleShowDetail(item.id_barang)}>
								<div className="card-body p-4 relative">
									<div className="flex justify-between items-start">
										<h3 className="card-title text-lg">{item.nama_barang}</h3>
										<span className={`badge ${getBadgeColor(item.status_proses || "")} gap-2`}>{item.status_proses}</span>
									</div>
									<p className="text-sm opacity-75">
										🕒 {["23 Mei 2025 - 19:10", "23 Mei 2025 - 20:15", "24 Mei 2025 - 12:46"][idx]}
									</p>
									{isLoadingDetailBarang === item.id_barang && (
										<div className="absolute top-0 left-0 w-full h-full flex justify-center items-center bg-base-200/70">
											<FaSpinner className="w-4 h-4 ml-2 animate-spin" />
										</div>
									)}
								</div>
							</div>
						))}
						{data?.data.tugas_berikutnya.length === 0 && <p className="text-sm text-gray-500">Tidak ada tugas berikutnya.</p>}
					</div>
				</div>

				{/* Footer */}
				<div className="mt-14 mb-12">
					<Footer />
				</div>
			</div>
		</div>
	);
};

export default HomePage;
