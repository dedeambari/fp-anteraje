export const formatDate = (dateString: string): string => {
	if (!dateString) return "-";
	try {
		const date = new Date(dateString);
		return date.toLocaleDateString("id-ID", {
			weekday: "long",
			day: "numeric",
			month: "long",
			year: "numeric",
			hour: "2-digit",
			minute: "2-digit"
		});
	} catch {
		return dateString;
	}
};

export const getBadgeColor = (status: string) => {
	switch (status.toLowerCase()) {
		case "diterima":
			return "badge-success";
		case "diproses":
			return "badge-warning";
		case "diantar":
			return "badge-info";
		default:
			return "badge-ghost";
	}
};


export const formatNumber = (num?: number) => {
  if (num === undefined || num === null) return "0";
  if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, "") + "k";
	if (num <= 0) {
		return null;
	}
  return num.toString();
};


export function debounce(func: (...args: any[]) => void, delay: number) {
	let timeoutId: ReturnType<typeof setTimeout>;
	return (...args: any[]) => {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => func(...args), delay);
	};
}