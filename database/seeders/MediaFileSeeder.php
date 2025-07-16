<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mediaFile = [
            'https://photo.znews.vn/w1000/Uploaded/znang2/2025_07_16/iStock_1399575283.jpeg',
            'https://photo.znews.vn/w480/Uploaded/qoswae/2025_07_16/front_pages_books_curl_humidity_2.jpg',
            'https://photo.znews.vn/w480/Uploaded/zgsgtn/2025_07_05/giong_doc_AI_thay_the_nguoi_doc_sach_noi.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_07_15/edit_490_1713178571253251397662.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_07_14/15_ngang.jpg',
            'https://photo.znews.vn/w480/Uploaded/qoswae/2025_07_07/2953.jpg',
            'https://photo.znews.vn/w480/Uploaded/ozlyestesfj/2025_07_03/Thumbnail_3.jpg',
            'https://photo.znews.vn/w480/Uploaded/cqjrzdhwq/2025_07_12/Znews_Khong_con_benh_tim.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_01_04/Phu_nu_hanh_phuc.jpg',
            'https://photo.znews.vn/w480/Uploaded/cqjrzdhwq/2025_07_09/pexels_byaghooti_11310902_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_05_21/Phu_nu_lam_viec.jpg',
            'https://photo.znews.vn/w480/Uploaded/znang2/2025_07_10/58a3c3f66169efb0e53b4cbff8b5caf6.jpeg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_07_09/Nhay_viec.jpg',
            'https://photo.znews.vn/w480/Uploaded/sgtnrn/2025_06_12/sach_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/znang2/2025_07_08/full_length_body_size_photo_chee.jpeg',
            'https://photo.znews.vn/w480/Uploaded/zgsgtn/2025_07_02/514947694_1147096850791381_83000.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_12_01/Ban_linh_lam_viec.JPG',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_05_03/Muc_tieu_cuoc_doi.JPG',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_07_07/Nu_sinh_2.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_07_07/Thiet_ke_chua_co_ten_7_.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_07_05/Phu_nu_thanh_cong.jpeg',
            'https://photo.znews.vn/w480/Uploaded/qoswae/2025_07_04/fireworks.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_04_28/Khoi_nghiep.jpg',
            'https://photo.znews.vn/w480/Uploaded/zgsgtn/2025_07_02/cuoc_thi_viet_chua_lanh_sach_noi.jpg',
            'https://photo.znews.vn/w480/Uploaded/jopluat/2025_07_01/ong_noi.jpg',
            'https://photo.znews.vn/w480/Uploaded/jopluat/2025_07_01/Thiet_ke_chua_co_ten_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/pwivogmv/2025_06_30/Thiet_ke_chua_co_ten_7_.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_03_12/Nhan_vien_cong_so.jpg',
            'https://photo.znews.vn/w480/Uploaded/znang2/2025_06_30/femme_photographe_prenant_photo.jpeg',
            'https://photo.znews.vn/w480/Uploaded/sgtnrn/2025_06_18/gap_toi_tuong_lai_2.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_06_29/DSCF1923.JPG',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_05_12/Nhan_vien_cong_so.JPG',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_06_26/Song_Hye_Kyo.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_06_26/devan_5.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_04_28/Khoi_nghiep.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_06_25/Tap_thien.jpg',
            'https://photo.znews.vn/w480/Uploaded/sgtnrn/2025_06_12/sach.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_06_22/Lan_da_dep.JPG',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_05_04/pexels_antonius_ferret_6223025.jpg',
            'https://photo.znews.vn/w480/Uploaded/cqjrzdhwq/2025_06_21/tu_do_tai_chinh.thumb.800.480.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_12_27/Doi_song_cong_so.jpg',
            'https://photo.znews.vn/w480/Uploaded/sgtnrn/2025_06_19/sach_bao_chi.jpg',
            'https://photo.znews.vn/w480/Uploaded/zgsgtn/2025_06_13/thuyen_nguyen_duc_tung.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_03_30/Cang_thang.JPG',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_06_18/505737254_122102041874900493_6041439886689265019_n_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_06_17/Yoga.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2024_07_03/Lua_chon_mua_sam.jpg',
            'https://photo.znews.vn/w480/Uploaded/bpcgpivp/2025_06_07/thumb_thu_vien_Goethe.jpg',
            'https://photo.znews.vn/w480/Uploaded/ofh_cgkztmzt/2025_06_11/Thieu_nu_noi_loan.jpeg',
            'https://photo.znews.vn/w480/Uploaded/sgorvz/2025_07_15/lao_hoa_som.jpg',
            'https://photo.znews.vn/w480/Uploaded/rotnrz/2024_08_15/447895200_993432485472925_1885202148696381332_n_1.jpg',
            'https://photo.znews.vn/w480/Uploaded/rohunaa/2025_07_15/z6807988816277_e5108b43002926edf4e61718b191675b.jpg',
            'https://photo.znews.vn/w480/Uploaded/qfssu/2025_07_16/BetterImage_1752634805117_1.jpeg',
        ];

        $userIds = \App\Models\User::where('is_author', true)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();

        foreach ($mediaFile as $index => $item) {
            $index++;
            $extension = pathinfo(parse_url($item, PHP_URL_PATH), PATHINFO_EXTENSION);

            \App\Models\MediaFile::create([
                'name' => "Ảnh demo $index",
                'file_path' => $item,
                'mime_type' => "image/$extension",
                'size' => rand(10000, 500000),
                'user_id' => $userIds[array_rand($userIds)],
            ]);
        }
    }
}
