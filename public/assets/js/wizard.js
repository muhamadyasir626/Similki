$(function () {
    "use strict";

    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
    });

    // hide all
    $(
        "#form-jenis_koleksi, #form-asal_satwa, #form-status_perlindungan, #form-confirm_no_sats-ln, #form-no_sats-ln, #form-pengambilan_satwa, #form-confirm_sk_menteri, #form-sk_menteri, #form-confirm_sk_kepala, #form-sk_kepala, #form-confirm_sk_ksdae, #form-sk_ksdae"
    ).hide();

    $("input[name='satwa_koleksi']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-jenis_koleksi").show();
            $("#form-asal_satwa").hide();
            $("#form-confirm_no_sats-ln").hide();
            $("#form-status_perlindungan").hide();
            $("#form-no_sats-ln").hide();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-jenis_koleksi").hide();
            $("#form-asal_satwa").hide();
            $("#form-confirm_no_sats-ln").hide();
            $("#form-status_perlindungan").hide();
            $("#form-no_sats-ln").hide();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("#form-jenis_koleksi input[type='radio']").on("change", function () {
        $("#form-asal_satwa").show();
        $("#form-confirm_no_sats-ln").hide();
        $("#form-status_perlindungan").hide();
        $("#form-no_sats-ln").hide();
        $("#form-pengambilan_satwa").hide();
        $("#form-confirm_sk_kepala").hide();
        $("#form-sk_kepala").hide();
        $("#form-confirm_sk_menteri").hide();
        $("#form-confirm_sk_ksdae").hide();
        $("#form-sk_menteri").hide();
        $("#form-sk_ksdae").hide();
    });

    $("input[name='asal_satwa']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-status_perlindungan").show();
            $("#form-confirm_no_sats-ln").hide();
            $("#form-no_sats-ln").hide();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-confirm_no_sats-ln").show();
            $("#form-status_perlindungan").hide();
            $("#form-no_sats-ln").hide();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='confirm_no_sats-ln']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-no_sats-ln").show();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-no_sats-ln").hide();
            $("#form-pengambilan_satwa").hide();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='status_perlindungan']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-pengambilan_satwa").show();
            $("#form-confirm_sk_kepala").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-confirm_sk_kepala").show();
            $("#form-pengambilan_satwa").hide();
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='confirm_sk_kepala']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-sk_kepala").show();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-sk_kepala").hide();
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='pengambilan_satwa']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-confirm_sk_menteri").show();
            $("#form-confirm_sk_ksdae").hide();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-confirm_sk_menteri").hide();
            $("#form-confirm_sk_ksdae").show();
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='confirm_sk_menteri']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-sk_menteri").show();
            $("#form-sk_ksdae").hide();
        } else {
            $("#form-sk_menteri").hide();
            $("#form-sk_ksdae").hide();
        }
    });

    $("input[name='confirm_sk_ksdae']").on("change", function () {
        if ($(this).val() === "Ya") {
            $("#form-sk_ksdae").show();
        } else {
            $("#form-sk_ksdae").hide();
        }
    });
});
