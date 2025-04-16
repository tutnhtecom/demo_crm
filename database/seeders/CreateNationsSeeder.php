<?php

namespace Database\Seeders;

use App\Models\Nations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateNationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nations::Truncate();
        $data = [
            ["name" => "Kinh"],
            ["name" => "Tày"],
            ["name" => "Thái"],
            ["name" => "Mường"],
            ["name" => "Hoa"],
            ["name" => "Khơ-me"],
            ["name" => "Nùng"],
            ["name" => "H’mông"],
            ["name" => "Dao"],
            ["name" => "Gia-rai"],
            ["name" => "Ê-đê"],
            ["name" => "Ba-na"],
            ["name" => "Sán Chay"],
            ["name" => "Chăm"],
            ["name" => "Xơ-đăng"],
            ["name" => "Sán Dìu"],
            ["name" => "Hrê"],
            ["name" => "Cơ-ho"],
            ["name" => "Ra-glai"],
            ["name" => "Mnông"],
            ["name" => "Thổ"],
            ["name" => "Xtiêng"],
            ["name" => "Khơmú"],
            ["name" => "Bru-Vân Kiều"],
            ["name" => "Giáy"],
            ["name" => "Cơ-tu"],
            ["name" => "Gié-Triêng"],
            ["name" => "Ta-ôi"],
            ["name" => "Mạ"],
            ["name" => "Co"],
            ["name" => "Chơ-ro"],
            ["name" => "Hà Nhì"],
            ["name" => "Xinh Mun"],
            ["name" => "Chu-ru"],
            ["name" => "Lào"],
            ["name" => "La-chí"],
            ["name" => "Phù Lá"],
            ["name" => "La Hủ"],
            ["name" => "Kháng"],
            ["name" => "Lự"],
            ["name" => "Pà Thẻn"],
            ["name" => "LôLô"],
            ["name" => "Chứt"],
            ["name" => "Mảng"],
            ["name" => "Cờ lao"],
            ["name" => "Bố Y"],
            ["name" => "La Ha"],
            ["name" => "Cống"],
            ["name" => "Ngái"],
            ["name" => "Si La"],
            ["name" => "Pu Péo"],
            ["name" => "Brâu"],
            ["name" => "Rơ-măm"],
            ["name" => "Ơ-đu"],
            ["name" => "Hán"]
        ];
        Nations::insert($data);
    }
}
