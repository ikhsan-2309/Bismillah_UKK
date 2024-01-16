function getHariTanggal() {
  let tanggal = new Date();
  let hari = tanggal.toLocaleDateString("id-ID", { weekday: "long" });
  let tanggalFormat = tanggal.toLocaleDateString("id-ID", { day: "numeric", month: "long" });
  return hari + ", " + tanggalFormat;
}