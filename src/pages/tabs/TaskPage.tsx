import { useTaskStore } from "@/store/useTaskStore"
import type { DataItem, ResponseTask } from "@/types"
import { getBadgeColor } from "@/utils/helper"
import { FaCamera, FaClock, FaCommentAlt, FaReceipt, FaSpinner, FaTags } from "react-icons/fa"
import { BuktiPreview } from "@/components/BuktiPreview"
import toast from "react-hot-toast"
import { useNavigate } from "react-router-dom"
import { useTabStore } from "@/store/useTabsStore"


const TaskPage = () => {
	const {
		data: dataTask,
		isLoadingDetailBarang,
		fetchDetailBarang,
		setSelectedBarang,
	} = useTaskStore()

	const { activeTabTask, setActiveTabTask } = useTabStore();

	const tabs: ("diproses" | "diantar" | "diterima")[] = ["diproses", "diantar", "diterima"]

	const { data } = dataTask as ResponseTask;

	const navigate = useNavigate();
	const handleShowDetail = async (id_barang: number) => {
		try {
			await fetchDetailBarang?.(id_barang);
			navigate("/detail");
		} catch (error: any) {
			toast.error("Gagal menampilkan detail barang " + error.message);
		}
	};

	const handleUpdateProsess = (id_barang: number) => {

		// Ambil data dari tab sekarang
		const dataUpdate = data?.[activeTabTask].find(item => item.id === id_barang);
		if (!dataUpdate) return;

		setSelectedBarang(dataUpdate);

		// Buka modal
		const modal = document.getElementById("modal-update-prosess") as HTMLDialogElement;
		modal?.showModal();
	};


	return (
		<div className="overflow-hidden">
			<div className="pt-4 border-b border-error h-[calc(100vh-180px)]">
				{/* Tabs */}
				<div className="flex items-center justify-between">
					{tabs.map(tab => (
						<button
							key={tab}
							onClick={() => setActiveTabTask(tab)}
							className={`py-2 w-full px-4  ${activeTabTask === tab ?
								"border-b border-base-100 font-semibold text-secondary bg-base-100 rounded-t-xl" :
								"border-transparent"
								}`}
						>
							{tab.charAt(0).toUpperCase() + tab.slice(1)}
						</button>
					))}
				</div>

				{/* Content */}
				<ul
					className="pt-2 px-2 bg-base-100 h-[calc(100vh-245px)] overflow-y-auto">
					<li className="px-4 py-3 text-xs backdrop-blur tracking-wide sticky -top-2 z-10 ">
						Tugas yang sedang {activeTabTask}
					</li>

					{data[activeTabTask]?.length > 0 ? (
						data[activeTabTask].map((item: DataItem) => (
							<li key={item.id} className="card bg-base-100 shadow-sm hover:shadow-md transition-shadow mb-5">
								<div className="card-body p-4">
									<div className="flex justify-between items-start">
										<h3 className="card-title text-lg font-medium capitalize truncate w-full">{item.nama_barang}</h3>
										<span className={`capitalize badge ${getBadgeColor(item.status_proses || "")}`}>
											{item.status_proses}
										</span>
									</div>

									<p className="text-sm text-gray-600 mt-1">{item.deskripsi_barang}</p>

									<div className="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-sm">
										<div className="flex items-center">
											<FaReceipt className="w-4 h-4 mr-1 opacity-70" />
											<span className="text-gray-500">Resi: {item.nomor_resi}</span>
										</div>

										<div className="flex items-center">
											<FaTags className="w-4 h-4 mr-1 opacity-70" />
											<span className="text-gray-500">{item.kategori}</span>
										</div>
									</div>

									<div className="flex items-center mt-2 text-sm">
										<FaClock className="w-4 h-4 mr-1 opacity-70" />
										<span className="text-gray-500">Estimasi: {item.estimasi_waktu}</span>
									</div>

									{item.deskripsi_barang && (
										<div className="mt-3 p-3 bg-base-200 rounded-lg">
											<div className="flex items-start">
												<FaCommentAlt className="w-4 h-4 mr-1 opacity-70" />
												<span className="text-sm italic text-gray-600">"{item.deskripsi_barang}"</span>
											</div>
										</div>
									)}

									{item.bukti && (
										<div className="mt-3">
											<div className="text-xs text-gray-500 mb-1 flex items-center">
												<FaCamera className="w-4 h-4 mr-1 opacity-70" />
												Bukti:
											</div>
											<BuktiPreview nomorResi={item.nomor_resi || ""} image={item.bukti} />
										</div>
									)}

									<div className="border-t border-gray-200 pt-3 w-full flex gap-2 justify-end">
										<button className="btn btn-accent btn-sm btn-soft"
											onClick={() => handleUpdateProsess(item.id_barang)}
										>
											Update Prosess
										</button>

										<button className="btn btn-primary btn-sm btn-soft"
											onClick={() => handleShowDetail(item.id_barang)}
										>
											Show Detail
											{isLoadingDetailBarang === item.id_barang && <FaSpinner className="w-4 h-4 ml-2 animate-spin" />}
										</button>
									</div>
								</div>
							</li>
						))
					) : (
						<div className="flex flex-col items-center justify-center py-10">
							<svg className="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							<p className="text-gray-500 mt-2">Tidak ada data</p>
						</div>
					)}
				</ul>

			</div>
		</div>
	)
}

export default TaskPage
