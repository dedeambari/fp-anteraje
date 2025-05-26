export interface TrackingResponse {
	statusCode: number;
	error: boolean;
	message: string;
	data: TrackingData;
}

export interface TrackingData {
	id: number;
	nama_barang: string;
	deskripsi_barang: string;
	berat: string;
	volume: string;
	nomor_resi: string;
	id_kategori: number;
	id_pengirim: number;
	id_penerima: number;
	total_tarif: string;
	created_at: string;
	updated_at: string;
	deleted_at: string | null;
	kategori: Kategori;
	pemrosessan: Pemrosesan;
	payment: Payment;
	penerima: PenerimaPengirim;
	pengirim: PenerimaPengirim;
	history_progress_barang: HistoryProgress[];
	kode_barang?: string;
}

export interface Kategori {
	id_kategori: number;
	nama_kategori: string;
	hitung_berat: number;
	hitung_volume: number;
	tarif_per_kg: string;
	tarif_per_m3: string;
	tarif_flat: string;
	biaya_tambahan: string;
	created_at: string;
	updated_at: string;
}

export interface Pemrosesan {
	id: number;
	id_barang: number;
	id_staf: number;
	status_proses: "diproses" | "diantar" | "diterima" | string;
	catatan: string;
	bukti: string | null;
	estimasi_waktu: string;
	created_at: string;
	updated_at: string;
	staf: Staf;
}

export interface Staf {
	id: number;
	nama: string;
	no_hp: string;
	transportasi: string;
}

export interface Payment {
	id: number;
	id_barang: number;
	pays: "penerima" | "pengirim" | string;
	status: "belum_bayar" | "dibayar" | "dikonfirmasi" | string;
	created_at: string;
	updated_at: string;
}

export interface PenerimaPengirim {
	id: number;
	nama: string;
	alamat: string;
	no_hp: string;
	created_at: string;
	updated_at: string;
	deleted_at: string | null;
}

export interface HistoryProgress {
	id: number;
	id_barang: number;
	id_staf: number;
	status_proses: string;
	catatan: string;
	bukti: string | null;
	created_at: string;
	updated_at: string;
}

export interface ErrorType {
	statusCode: number;
	error: boolean;
	message: string;
}

export interface Response {
	statusCode: number;
	message: string;
}

export interface ResponseAuth extends Response {
	token: string;
	staf: Staf;
}

export interface Staf {
	id: number;
	nama: string;
	username: string;
	no_hp: string;
	password: string;
	qty_task: number;
	profile: string | null;
	transportasi: string;
	created_at?: string;
	updated_at?: string;
	deleted_at?: string | null;
	reset_otp?: string | null;
	reset_otp_expired_at?: string | null;
}

export interface ResponseHome extends Response {
	data: HomeData;
}

export interface HomeData {
	nama: string;
	username: string;
	no_hp: string;
	sisa_jumlah_tugas?: number | null;
	total_barang?: number | null;
	total_barang_diantar?: number | null;
	total_barang_diterima?: number | null;
	tugas_baru_selesai: DataItem;
	tugas_berikutnya: DataItem[];
}

type DataItem = {
	id: number;
	id_barang: number;
	status_proses: string | null;
	catatan: string | null;
	bukti: string | null;
	estimasi_waktu: string | null;
	nomor_resi: string | null;
	nama_barang: string;
	deskripsi_barang: string;
	kategori: string;
	created_at?: string | null;
	updated_at?: string | null;
};

export interface ResponseTask extends Response {
	data: TaskData;
}

export interface TaskData {
	diproses: DataItem[];
	diantar: DataItem[];
	diterima: DataItem[];
}

export interface ResponseDetailBarang extends Response {
  data: DetailBarangData;
}

export interface DetailBarangData {
  pemrosessan: Pemrosesan;
  barang: Barang;
  kategori: Kategori;
  payment: Payment;
  pengirim: PengirimPenerima;
  penerima: PengirimPenerima;
  history: HistoryItem[];
}

export interface Pemrosesan {
  id: number;
  status_proses: string;
  catatan: string | null;
  bukti: string;
  estimasi_waktu: string;
}

export interface Barang {
  id: number;
  nama_barang: string;
  deskripsi_barang: string;
  berat: string;
  volume: string;
  nomor_resi: string;
  total_tarif: string;
}

export interface Kategori {
  id_kategori: number;
  nama_kategori: string;
  hitung_berat: number;
  hitung_volume: number;
  tarif_per_kg: string;
  tarif_per_m3: string;
  tarif_flat: string;
  biaya_tambahan: string;
}

export interface Payment {
  id: number;
  id_barang: number;
  pays: string;
  status: string;
}

export interface PengirimPenerima {
  id: number;
  nama: string;
  alamat: string;
  no_hp: string;
}

export interface HistoryItem {
  id: number;
  id_barang: number;
  id_staf: number;
  status_proses: string;
  catatan: string | null;
  bukti: string | null;
  created_at: string;
  updated_at: string;
}
