$(function () {
    "use strict";

    $(
        "#form-jumlah, #form-jumlah_keseluruhan_gender, #form-jenis_kelamin, #form-confirm_tagging, #form-alasan_belum_tagging, #form-jenis_tagging, #kode_tagging, #form-ba_tagging, #form-tanggal_tagging, #form-no_ba_titipan, #form-no_ba_kelahiran, #form-no_ba_kematian, #form-nama_panggilan, #form-validasi_tanggal, #form-tahun_titipan, #form-keterangan, #form-nama_satwa_ina, #form-nama_panggilan, #takson_hewan, #form-total_satwa       "
    ).hide();

    $("input[name='perilaku_satwa']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-jumlah").show();
            $("#form-jenis_kelamin").hide();
            $("#form-jumlah_keseluruhan_gender").hide();
            $("#takson_hewan").hide();
            $("#form-total_satwa").show();
            $("#form-jenis_tagging").hide();
            $("#kode_tagging").hide();
            $("#form-ba_tagging").hide();
            $("#form-tanggal_tagging").hide();
            $("#form-no_ba_titipan").hide();
            $("#form-no_ba_kelahiran").hide();
            $("#form-no_ba_kematian").hide();
            $("#form-alasan_belum_tagging").hide();
            $("#form-nama_panggilan").show();
            $("#form-validasi_tanggal").hide();
            $("#form-tahun_titipan").hide();
            $("#form-keterangan").hide();
            $("#form-nama_satwa_ina").hide();
            $("#form-nama_panggilan").hide();
        } else {
            $("#form-jumlah").hide();
            $("#form-jenis_kelamin").show();
            $("#form-jumlah_keseluruhan_gender").show();
            $("#takson_hewan").show();
            $("#form-total_satwa").hide();
            $("#form-jenis_tagging").hide();
            $("#kode_tagging").hide();
            $("#form-ba_tagging").hide();
            $("#form-tanggal_tagging").hide();
            $("#form-no_ba_titipan").hide();
            $("#form-no_ba_kelahiran").hide();
            $("#form-no_ba_kematian").hide();
            $("#form-alasan_belum_tagging").hide();
            $("#form-nama_panggilan").hide();
            $("#form-validasi_tanggal").hide();
            $("#form-tahun_titipan").hide();
            $("#form-keterangan").hide();
            $("#form-nama_satwa_ina").hide();
            $("#form-nama_panggilan").hide();
        }
    });
    $("#form-jenis_kelamin input[type='radio']").on("change", function () {
        $("#form-confirm_tagging").show();
    });
    $("input[name='confirm_tagging']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-jenis_tagging").show();
            $("#kode_tagging").show();
            $("#form-ba_tagging").show();
            $("#form-tanggal_tagging").show();
            $("#form-no_ba_titipan").show();
            $("#form-no_ba_kelahiran").show();
            $("#form-no_ba_kematian").show();
            $("#form-alasan_belum_tagging").hide();
            // $("#form-nama_panggilan").show();
            $("#form-validasi_tanggal").show();
            $("#form-tahun_titipan").show();
            $("#form-keterangan").show();
            $("#form-nama_satwa_ina").show();
            $("#form-nama_panggilan").show();
        } else {
            $("#form-jenis_tagging").hide();
            $("#kode_tagging").hide();
            $("#form-ba_tagging").hide();
            $("#form-tanggal_tagging").hide();
            $("#form-no_ba_titipan").hide();
            $("#form-no_ba_kelahiran").hide();
            $("#form-no_ba_kematian").hide();
            $("#form-alasan_belum_tagging").show();
            $("#form-validasi_tanggal").show();
            $("#form-tahun_titipan").show();
            $("#form-keterangan").show();
            $("#form-nama_satwa_ina").show();
            // $("#form-nama_panggilan").show();
        }
    });
});
