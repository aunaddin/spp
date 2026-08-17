<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Render tombol pagination, otomatis mempertahankan filter GET yang sudah ada (bulan, tahun, keyword, dst)
function render_pagination($current_page, $total_pages)
{
    if ($total_pages <= 1) return;

    $get_params = $_GET;

    $build_url = function($page) use ($get_params) {
        $get_params['page'] = $page;
        return '?' . http_build_query($get_params);
    };

    echo '<nav><ul class="pagination justify-content-center">';

    // Tombol Previous
    if ($current_page > 1) {
        echo '<li class="page-item"><a class="page-link" href="' . $build_url($current_page - 1) . '">&laquo;</a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
    }

    // Nomor halaman (maks 5 nomor terlihat, geser sesuai posisi halaman aktif)
    $start = max(1, $current_page - 2);
    $end   = min($total_pages, $current_page + 2);

    if ($start > 1) {
        echo '<li class="page-item"><a class="page-link" href="' . $build_url(1) . '">1</a></li>';
        if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        $active = ($i == $current_page) ? ' active' : '';
        echo '<li class="page-item' . $active . '"><a class="page-link" href="' . $build_url($i) . '">' . $i . '</a></li>';
    }

    if ($end < $total_pages) {
        if ($end < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        echo '<li class="page-item"><a class="page-link" href="' . $build_url($total_pages) . '">' . $total_pages . '</a></li>';
    }

    // Tombol Next
    if ($current_page < $total_pages) {
        echo '<li class="page-item"><a class="page-link" href="' . $build_url($current_page + 1) . '">&raquo;</a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
    }

    echo '</ul></nav>';
}