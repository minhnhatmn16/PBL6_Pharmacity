<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'brand_name' => 'Pharmacity',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/20240621025440-0-newlogopharmacity.png',
                'brand_description' => 'Bên cạnh chuỗi Nhà thuốc tiện lợi, Pharmacity cho ra mắt những sản phẩm mang thương hiệu Pharmacity từ năm 2015 với các mặt hàng, hạng mục ngày càng đa dạng. Tính đến nay, Pharmacity đang sở hữu và phân phối hàng trăm mã sản phẩm mang thương hiệu riêng, thuộc các lĩnh vực chăm sóc sức khỏe, chăm sóc cá nhân, chăm sóc sắc đẹp, vitamin và thực phẩm chức năng cùng các sản phẩm tiện lợi.Với tiêu chí cam kết về chất lượng, giá cả phải chăng, phù hợp với nhu cầu của mọi khách hàng, trong thời gian tới Pharmacity tiếp tục phát triển thêm nhiều dòng sản phẩm mới mang thương hiệu riêng, hướng đến trở thành thương hiệu được người tiêu dùng trao trọn niềm tin và sức khỏe.'
            ],
            [
                'brand_name' => 'Abbott',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/4_Abbott.jpg',
                'brand_description' => 'Abbott là công ty chăm sóc sức khỏe hàng đầu thế giới, chuyên nghiên cứu, phát triển, sản xuất và đưa ra các sản phẩm và dịch vụ chăm sóc sức khỏe có chất lượng cao trong lĩnh vực dinh dưỡng, dược phẩm, thiết bị chẩn đoán và điều trị. Phương châm toàn diện của các sản phẩm Abbott là phục vụ cuộc sống – toàn tâm với nhu cầu chăm sóc sức khỏe từ trẻ em đến người lớn tuổi.'
            ],
            [
                'brand_name' => 'Hasan- Demarpharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hasan--demarpharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Agi',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/agi.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Agimexpharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/agimexpharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'AGHIPHARM',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/agipharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Alpex Pharm S.A',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/alpex-pharma-sa.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Ampharco U.S.A',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ampharco-usa.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'An Thien',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/an-thien.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Apimed',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/apimed.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'BIDIPHAR',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/bidiphar.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Boston',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/boston.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Công ty cổ phần dược Đồng Nai',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Công ty cổ phần Dược phẩm Quảng Bình',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/cong-ty-co-phan-duoc-pham-quang-binh.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Công ty Cổ phần Dược phẩm Bến Tre',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/cong-ty-co-phan-duoc-pham-ben-tre.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Air-X',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/air-x.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Ba Đình',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ba-dinh.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Exeltis',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/exeltis.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Gedeon Richter',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/gedeon-richter.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'NEW CHOICE',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Danapha',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/danapha.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Davipharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/davipharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'DHG Pharma',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/24_DHG.png',
                'brand_description' => 'Công ty DHG Pharma là đơn vị nằm trong top đầu ngành Công nghiệp Dược Việt Nam, sở hữu số lượng lớn sản phẩm thuốc trên thị trường hiện nay nhằm đáp ứng nhu cầu cho người tiêu dùng. Công ty DHG Pharma hay còn được biết đến là Công ty Cổ phần Dược Hậu Giang, có lịch sử phát triển từ năm 1975 và liên tục đổi mới trong 40 năm qua.Sản phẩm thuốc của công ty DHG Pharma được chia thành 9 nhóm lớn bao gồm:• Nhóm thuốc kháng sinh Nhóm thuốc giảm đau - hạ sốt • Nhóm thuốc hô hấp Nhóm thuốc thần kinh - nhãn khoa • Nhóm thuốc cơ xương khớp Nhóm thuốc tim mạch - đái tháo đường • Nhóm thuốc dinh dưỡng • Nhóm thuốc da liễu - chăm sóc sắc đẹp • Nhóm thuốc tiêu hóa - gan mật'
            ],
            [
                'brand_name' => 'Vidipha',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/vidipha.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'US Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/us-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'TVPharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/tvpharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Tranphaco',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'STELLA',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/15_Stella.png',
                'brand_description' => 'Công ty TNHH Liên doanh Stellapharm được thành lập vào năm 2000 (tiền thân là Công ty TNHH Liên doanh STADA – Việt Nam), hiện là doanh nghiệp sản xuất dược đứng đầu trong lĩnh vực xuất khẩu dược phẩm tại Việt Nam, đặc biệt là thị trường các nước Châu Âu. Các sản phẩm của Stella hiện đang được tin dùng bởi hàng triệu bệnh nhân tại hơn 50 quốc gia trên toàn thế giới.'
            ],
            [
                'brand_name' => 'SPM',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/spm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Sanofi CHC Local',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/sanofi-chc-local.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'S.C.Arena Group S.A.',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Pymepharco',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/88_Pymepharco.png',
                'brand_description' => 'Công ty Cổ phần Pymepharco tiền thân là Công ty Dược và Vật tư Y tế Phú Yên, được thành lập vào năm 1989. Vào tháng 05/2006, công ty chính thức chuyển đổi thành Công ty Cổ phần Pymepharco. Sau hơn 30 năm hình thành và phát triển, Pymepharco đã và đang đạt được rất nhiều thành tựu ấn tượng trong lĩnh vực sản xuất, kinh doanh dược phẩm. Đầu tháng 10/2003, Nhà máy dược phẩm Pymepharco đạt tiêu chuẩn GMP (ASEAN) chính thức đi vào hoạt động với 3 phân xưởng Beta–lactam, Non–Beta lactam, Viên nang mềm, và rồi trở thành nhà máy đạt tiêu chuẩn GMP-WHO đầu tiên tại Việt Nam vào năm 2005. Pymepharco đã tạo được thế vững chắc và có uy tín trên thị trường trong và ngoài nước. Sản phẩm Pymepharco được xuất khẩu sang thị trường các nước trong khu vực như Hong Kong, Malaysia, Philippines…và thâm nhập vào thị trường Châu Âu (Đức).'
            ],
            [
                'brand_name' => 'Pharmedic',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/67_Pharmadic.png',
                'brand_description' => 'Công Ty Cổ Phần Dược Phẩm Dược Liệu Pharmedic tiền thân là Công Ty Xuất Nhập Khẩu Trực Dụng Y Tế Pharimex được thành lập ngày 30/06/1981. Với gần 40 năm kinh nghiệm trong sản xuất và xuất khẩu dược phẩm, dược liệu, mỹ phẩm, vật tư y tế và các sản phẩm khác thuộc ngành y tế, gia công chế biến 1 số nguyên phụ liệu, sản xuất mua bán 1 số hóa chất (trừ hóa chất độc hại)... Phát triển từ sản xuất đến kinh doanh, phân phối các sản phẩm trong nước, công ty có tiềm năng vươn ra thế giới trong tương lai. Ngoài ra công ty Pharmedic còn liên kết với các tổ chức trong và ngoài nước, chế biến nguyên phụ liệu có nguồn gốc dược liệu để sản xuất một số sản phẩm mang phong cách truyền thống.'
            ],
            [
                'brand_name' => 'Nadyphar',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nadyphar.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Meyer-BPC',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/meyer-bpc.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Merck Sharp & Dohme',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/11_Merck_Sharp__Dohme.png',
                'brand_description' => 'Merck Sharp & Dohme (còn được biết đến là Merck & Co., Inc. tại Mỹ và Canada) với trụ sở chính tại Mỹ. Thông qua việc cung cấp các loại sản phẩm thuốc kê đơn, vắc xin, liệu pháp sinh học và thuốc thú y, đến hiện tại MSD trở thành công ty dược phẩm lớn thứ 2 thế giới với hệ thống cơ sở hoạt động hơn 140 quốc gia nhằm cung cấp các giải pháp y tế tiên tiến nhất. Kể từ khi thành lập MSD đã có được bề dày kinh nghiệm nghiên cứu những năm đầu của thế kỷ 20 với công nghệ sản xuất vắc xin hiện đại nhất. Không dừng lại ở đó, MSD còn lần lượt nghiên cứu thành công thuốc điều trị bạch hầu, sởi, thuốc tim mạch... công ty đã khẳng định vị thế và tầm ảnh hưởng của mình đối với hệ thống dược phẩm thế giới.'
            ],
            [
                'brand_name' => 'Khanh Hoa',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/khanh-hoa.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Janssen',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/82_Janssen.png',
                'brand_description' => 'Thành lập vào năm 1953, Janssen là một công ty dược có trụ sở chính tại Bỉ và đến năm 1961, tập đoàn Johnson & Johnson của Mỹ đã mua lại Janssen và đã trở thành một trong những công ty của bộ phận nghiên cứu và phát triển dược phẩm của J&J. Sau gần 70 năm thành lập, Janssen đã đưa vào thị trường rất nhiều nghiên cứu về các loại thuốc điều trị các bệnh cần thiết bao gồm bệnh tim mạch, chuyển hóa, miễn dịch học...'
            ],
            [
                'brand_name' => 'GSK ETC',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/36_gsk_etc.png',
                'brand_description' => 'GlaxoSmithKline (GSK) là công ty dược phẩm chăm sóc sức khỏe toàn cầu của Anh. Công ty nghiên cứu và phát triển các sản phẩm trong 3 lĩnh vực là dược phẩm, vắc xin và chăm sóc sức khỏe người tiêu dùng.'
            ],
            [
                'brand_name' => 'Egis Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/egis-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Duoc pham 3/2',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/duoc-pham-3-2.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Domesco',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/domesco.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dong Duoc Phuc Hung',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dong-duoc-phuc-hung.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'OPC',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/74_opc_pharma.png',
                'brand_description' => 'Tiền thân của Công ty là Xí nghiệp Dược phẩm Trung Ương 26 thành lập vào tháng 10/1977. Đến năm 2002, Xí nghiệp được cổ phần hóa và đổi tên thành CTCP Dược phẩm OPC. Công ty Cổ phần Dược Phẩm OPC là một trong các công ty hàng đầu tại Việt Nam trong lĩnh vực sản xuất kinh doanh dược phẩm có nguồn gốc từ dược liệu, là đơn vị sản xuất thuốc có nguồn gốc dược liệu đầu tiên được Cục Quản Lý Dược-Bộ Y Tế VN cấp giấy chứng nhận GMP, GLP, GSP. Với nguyên liệu tốt, công ty phát triển kèm theo đó là nhà máy OPC Bình Dương đạt tiêu chuẩn GMP-WHO, áp dụng kỹ thuật công nghệ hiện đại đáp ứng kịp thời nhu cầu thị trường và phát triển bền vững trong tương lai.'
            ],
            [
                'brand_name' => 'Phil Inter Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/phil-inter-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Tatanol',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/tatanol.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'ARLICO',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/arlico.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Betadine',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/90_Betadine.png',
                'brand_description' => 'Betadine là thương hiệu của Mundipharma - một mạng lưới toàn cầu gồm các công ty liên kết độc lập nghiên cứu, phát triển và sản xuất các loại dược phẩm tân tiến và các sản phẩm chăm sóc sức khỏe người tiêu dùng. Các sản phẩm thuốc Betadine là một trong những loại thuốc chăm sóc sức khỏe rất nổi tiếng. Xuất phát từ chế phẩm khử trùng Povidone-iodine được sản xuất lần đầu tiên vào năm 1955, thương hiệu Betadine đã được đăng ký và tung ra thị trường quốc tế vào năm 1963. Betadine là lựa chọn hàng đầu để bảo vệ gia đình khỏi các vi trùng gây bệnh, được sử dụng để ngăn ngừa viêm họng, chăm sóc vết thương, chăm sóc phụ nữ… Không chỉ vậy các sản phẩm Betadine cũng được các chuyên gia chăm sóc sức khỏe tin dùng, được sử dụng rộng rãi trong các bệnh viện, phòng khám và phẫu thuật.'
            ],
            [
                'brand_name' => 'Bouchara',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/bouchara.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Decolgen',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/decolgen.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Difflam',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/difflam.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'DP Trung uong CPC1',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dp-trung-uong-cpc1.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Duoc Phuc Vinh',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/duoc-phuc-vinh.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Duoc VTYT Hai Duong',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/duoc-vtyt-hai-duong.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Eugica',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/eugica.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Excl. Enlie',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/excl-enlie.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Germany',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/germany.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'GLOMED-ABBOT',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/glomed-abbott.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Prospan',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/prospan.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'OPV',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/opv.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Sagopha',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/29_Sagopha.png',
                'brand_description' => 'Công ty TNHH Dược Phẩm Sài Gòn (Sagopha) là một trong những công ty sản xuất dược phẩm tư nhân đầu tiên thành lập tại Việt Nam, sau ngày thống nhất đất nước. Sản phẩm của Sagopha bao gồm thuốc từ dược liệu, thực phẩm chức năng và thuốc từ nguyên liệu hóa dược. Dòng sản phẩm chủ lực và chiến lược của Sagopha là thuốc từ dược liệu, thuốc được chiết xuất từ thảo dược và bào chế theo công nghệ hiện đại.'
            ],
            [
                'brand_name' => 'Sanofi CHC import',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/product/20240703034117-0-Sanofi%20CHC.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Strepsils',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/strepsils.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Tiffy',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/tiffy.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Unique Pharmaceutical Labs ',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'United Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/united-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Yen Bai',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/yen-bai.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Pharimexco',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/pharimexco.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Gonsa',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/gonsa.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'GSK OTC',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/31_gsk_otc.png',
                'brand_description' => 'GlaxoSmithKline (GSK) là công ty dược phẩm chăm sóc sức khỏe toàn cầu của Anh. Công ty nghiên cứu và phát triển các sản phẩm trong 3 lĩnh vực là dược phẩm, vắc xin và chăm sóc sức khỏe người tiêu dùng. GSK có rất nhiều thuốc và sản phẩm nổi tiếng, được ưa chuộng sử dụng cũng như thuốc đầu tay trong điều trị.Một số thuốc kinh điển của GSK như Paracetamol với tên biệt dược là Panadol, hiện nay là thuốc giảm đau, hạ sốt với doanh thu khổng lồ. Nhiều biệt dược khác có thể kể đến như Panadol extra, Panadol dạng viên sủi, Panadol cảm cúm cũng là những sản phẩm phổ biến trên thị trường. Các thuốc kháng sinh cũng là một mảng thế mạnh của công ty GSK. Các vaccin nổi tiếng của GSK có thể kể đến như Poliorix trong phòng bại liệt, Engerix B phòng viêm gan B và nhiều sản phẩm vaccin khác. GSK cũng có nhiều thành tựu và thành công trong phát minh ra các thuốc giúp điều trị hen, một chế phẩm nổi tiếng và thịnh hành hiện nay là Ventolin, chứa thành phần Salbutamol – hoạt chất đầu tay trong điều trị hen phế quản. Về mảng chăm sóc sức khỏe, sản phẩm Sensodyne đang là mặt hàng hot trong chăm sóc răng miệng, được ưa chuộng sử dụng rất nhiều tại Việt Nam cũng như các quốc gia khác trên thế giới.'
            ],
            [
                'brand_name' => 'Ha Tay',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ha-tay.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Hyphens Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hyphens-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Imexpharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/20240728015834-0-Imexpharm.png',
                'brand_description' => 'Với nền tảng vững chắc – hơn 45 năm kinh nghiệm trong sản xuất, điều chế, phân phối dược phẩm, Imexpharm nỗ lực không ngừng, liên tục cải tiến để trở thành người tiên phong trong ngành công nghiệp Dược tại Việt Nam. Imexpharm định vị trở thành doanh nghiệp dược trong dẫn đầu về chất lượng với sản phẩm được sản xuất từ các nhà máy đạt tiêu chuẩn Châu Âu.'
            ],
            [
                'brand_name' => 'Mediplantex',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/mediplantex.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Mekophar',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/mekophar.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Nam Ha',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nam-ha.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Roussel',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/roussel.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'STADA',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/stada.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Alcon Pharmaceuticals',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/20240322015240-0-Alcon.png',
                'brand_description' => 'Nhũ tương nhỏ mắt SYSTANE™ COMPLETE được sử dụng để làm giảm tạm thời các triệu chứng rát và kích ứng do khô mắt. Giải pháp tối ưu cho tất cả các loại khô mắt. Hiệu quả kéo dài suốt 8h chỉ sau liều duy nhất.'
            ],
            [
                'brand_name' => 'Allergan',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/allergan.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Bayer HealthCare',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/23_Bayer_Healthcare.png',
                'brand_description' => 'Công ty TNHH Bayer Việt Nam thuộc Tập đoàn Bayer đã hoạt động tại Việt Nam từ năm 1994 với hai nhà máy sản xuất hiện đại đặt tại Đồng Nai và Bình Dương và hai văn phòng tại Hà Nội và Thành phố Hồ Chí Minh hỗ trợ hoạt động kinh doanh chung của toàn công ty. Các sản phẩm của Bayer được chia làm 3 nhánh: nhánh Dược Phẩm tập trung vào các sản phẩm thuốc kê toa, đặc biệt là lĩnh vực tim mạch và chăm sóc sức khỏe phụ nữ, thuốc cản quang trong chẩn đoán hình ảnh và thuốc đặc trị trong ưng thư, huyết học và nhãn khoa; nhánh Chăm sóc Sức khỏe Người tiêu dùng tập trung chủ yếu vào thị trường các loại sản phẩm thuốc không kê toa; nhánh Khoa học Cây trồng tại Việt Nam cung cấp các sản phẩm thuốc trừ nấm, thuốc diệt cỏ và thuốc diệt trừ sâu bệnh hại trên cây trồng, bên cạnh đó là các giải pháp hạt giống lúa lai, hạt giống rau và các loại thuốc trừ dịch hại ngoài cây trồng.'
            ],
            [
                'brand_name' => 'FitoPharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/fitopharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Gia Nguyen',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/gia-nguyen.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Glenmark',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/glenmark.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'HanLim pharmaceutical',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hanlim-pharmaceutical.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Merap Group',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/60_Merap.png',
                'brand_description' => 'Merap Group là thương hiệu của công ty cổ phần tập đoàn Merap được thành lập vào năm 1999. Đây là công ty phân phối, sản xuất dược phẩm hàng đầu tại Việt Nam. Với 20 năm phát triển, Công ty có hệ thống phân phối trên khắp 63 tỉnh thành trong cả nước và nhà máy sản xuất thuốc tân dược đạt tiêu chuẩn GMP - WHO tại Văn Giang – Hưng Yên. Merap Group là chủ sở hữu nhiều thương hiệu dẫn đầu như thuốc nhỏ mắt OSLA, nước biển sâu XISAT… Các sản phẩm đã nhận được niềm tin về chất lượng, hiệu quả điều trị và sự tín nhiệm của các bác sĩ, dược sĩ cũng như người tiêu dùng.'
            ],
            [
                'brand_name' => 'Nam Duoc',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nam-duoc.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Nhat Nhat',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/52_Nh%E1%BA%A5t_Nh%E1%BA%A5t.png',
                'brand_description' => 'Nhất Nhất được thành lập năm 2006. Sau hơn 10 năm hoạt động, Nhất Nhất đã không ngừng phát triển để trở thành một trong những công ty dược phẩm lớn mạnh và uy tín hàng đầu Việt Nam, nhà máy sản xuất thuốc và hệ thống quản lý chất lượng theo tiêu chuẩn Thực hành tốt sản xuất thuốc theo khuyến cáo của Tổ chức Y tế thế giới (GMP-WHO). Để cho ra đời những sản phẩm Đông y thế hệ 2 - không phải hỗ trợ, bổ sung cho Tân dược, mà là thuốc điều trị chủ đạo, thuốc kê đơn, hiệu quả vượt trội, ít tác dụng phụ, Nhất Nhất đã đầu tư mạnh mẽ vào xây dựng Nhà máy Dược phẩm hiện đại. Tại đây, nguyên liệu đầu vào được chọn lọc, thu mua, kiểm tra chất lượng một cách nghiêm ngặt bởi phòng kiểm nghiệm đạt tiêu chuẩn GLP của Bộ Y tế. Nhờ vậy, các sản phẩm được Công ty sản xuất dưới dạng viên nén, viên nang, thuốc bột, thuốc nước, theo công nghệ bào chế và quản lý chất lượng hiện đại đã nhanh chóng chiếm được tín nhiệm cao của người tiêu dùng.'
            ],
            [
                'brand_name' => 'Nitto Medic',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nitto-medic.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Pharbaco (TW1)',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/pharbaco-tw1.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Quarsaw Pharma',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Samchundang',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/samchundang.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Santen',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/93_santen.png',
                'brand_description' => 'Santen xuất xứ thương hiệu Nhật Bản và được thành lập vào năm 1890, Santen đã góp phần nâng cao chất lượng cuộc sống của bệnh nhân trên toàn thế giới với bề dày kinh nghiệm trong lĩnh vực nhãn khoa. Santen có các trung tâm nghiên cứu và phát triển, sản xuất đẳng cấp thế giới, cung cấp sản phẩm trong các lĩnh vực trị liệu như mắt khô, bệnh về giác mạc, võng mạc, tăng nhãn áp, vv. cho bệnh nhân và chuyên gia y tế không chỉ ở Châu Á mà còn trên toàn thế giới. '
            ],
            [
                'brand_name' => 'Sao Thai Duong',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/75_Sao_thai_duong.png',
                'brand_description' => 'Được thành lập năm 2000, Sao Thái Dương là thương hiệu nổi tiếng của Việt Nam về sản xuất, kinh doanh dược mỹ phẩm và thực phẩm chức năng nguồn gốc thảo dược. Năm 2019 đánh dấu lần thứ sáu Sao Thái Dương được nhận giải thưởng Thương hiệu mạnh Việt Nam. Năm 2020, công ty vào tốp thương hiệu có sản phẩm tin dùng bởi người Việt Nam. Trong đó có nhiều sản phẩm đã trở thành thương hiệu truyền thống, gắn liên với công ty như: Kem nghệ Thái Dương, Dầu gội Thái Dương, dầu gừng Thái Dương, nhãn hiệu Tây Thi, hoặc nhiều thương hiệu được giới chuyên gia và người tiêu dùng đánh giá cao như Tuần hoàn não Thái Dương, viên vai gáy Thái Dương.'
            ],
            [
                'brand_name' => 'Systane',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/41_Systane.png',
                'brand_description' => 'Systane là thương hiệu đến từ Thụy Sỹ của công ty dược phẩm Alcon. Công ty hàng đầu trên thế giới trong lĩnh vực chăm sóc sức khỏe nhãn khoa.'
            ],
            [
                'brand_name' => 'Traphaco',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/traphaco.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'TW25',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/tw25.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Vrohto',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/vrohto.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Xoang Spray',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/xoang-spray.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Aptalis',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/aptalis.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Bioflora',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/bioflora.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Biopharco',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/biopharco.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Boganic',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/boganic.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Cho-A pharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/cho-a-pharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Daewoong Pharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/daewoong-pharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Donaipharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/donaipharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dragenopharm Apotheker Puschi GmbH',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dragenopharm-apotheker--puschi-gmbh.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Duoc lieu Tri Nghia',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/duoc-lieu-tri-nghia.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Fugacar',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/81_fugacar.png',
                'brand_description' => 'Fugacar là thuốc tẩy giun, đây là sản phẩm được sản xuất tại Việt Nam, theo công nghệ của Công ty Janssen Pharmaceutica tại Bỉ và là một sản phẩm được nhượng quyền sản xuất. Vì thế, dây chuyền công nghệ và công thức sản xuất đều đảm bảo đạt chuẩn và kiểm soát nghiêm ngặt nên hoàn toàn đảm bảo chất lượng. Ở thị trường Việt Nam, Fugacar được lưu hành với 2 dạng đóng gói: 1 viên và 4 viên (vị truyền thống, vị sô-cô-la, vị trái cây). Fugacar có tác dụng diệt các loại giun đũa, giun tóc, giun móc, giun kim đang kí sinh trong cơ thể người lớn và trẻ em trên 12 tháng tuổi. '
            ],
            [
                'brand_name' => 'Gaviscon',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/59_Gaviscon.png',
                'brand_description' => 'Gaviscon được sản xuất bởi Reckitt Benckiser tại Anh. Đây là thương hiệu hàng đầu trong việc điều trị ợ nóng & khó tiêu, hiện diện tại trên 70 quốc gia, và được tin dùng bởi hàng triệu người trên thế giới. Với thành phần chính là natri alginate, có nguồn gốc từ rong biển tự nhiên được thu hoạch bền vững dọc theo các bờ biển Na Uy, giúp ngăn sự tăng acid trong dạ dày, nguyên nhân chính gây ợ nóng và khó tiêu. Sản phẩm còn chứa chất kháng acid – calcium carbonate và natri bicarbonate – giúp trung hòa acid. Gaviscon có hiệu quả kéo dài hơn 4 giờ.'
            ],
            [
                'brand_name' => 'Gracure Pharmaceuticals, India',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/gracure-pharmaceuticals-india.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'HANOI PHARMA',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hanoi-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Hataphar',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hataphar.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Ipsen Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ipsen-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Johnson & Johnson',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/johnson-johnson.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Konimex',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/konimex.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Korea United Pharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/korea-united-pharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Lapophar - VN',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ladophar---vn.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Les Laboratoires',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/les-laboratoires.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Mebiphar',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/mebiphar.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Medisun',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/medisun.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Mega Lifesciences',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/10_Mega_Life.png',
                'brand_description' => 'Được thành lập vào năm 1982 tại Thái Lan, Mega Lifesciences tích cực tham gia vào việc giúp đỡ hàng triệu người có cơ hội tiếp cận các sản phẩm dinh dưỡng, thảo dược, thuốc kế toa và không kê toa an toàn, hiệu quả, chất lượng hàng đầu thế giới. Mega sản xuất các loại thuốc, sản phẩm dinh dưỡng và hàng tiêu dùng có chất lượng trên toàn thế giới. Tính đến thời điểm hiện tại, Mega đã có mặt ở gần 40 quốc gia thuộc Châu Á – Thái Bình Dương, Trung Đông, Châu Phi, Cộng đồng các quốc gia độc lập (CIS), Mỹ La-tinh và Châu Âu. Tại Việt Nam, Mega Wecare có mặt từ 1995, không ngừng mở rộng mạng lưới hoạt động và thị trường đồng thời đem đến những sản phẩm chất lượng, đáp ứng nhu cầu ngày càng cao của người tiêu dùng và giới chuyên môn.'
            ],
            [
                'brand_name' => 'Menarini',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/menarini.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Rosa-Phytopharma Laboratoires',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/rosa-phytopharma-laboratoires.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Rottapharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/rottapharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Rowa',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/92_Rowa.png',
                'brand_description' => 'Rowa là công ty dược phẩm có nguồn gốc từ Đức, được thành lập tại Ireland vào năm 1959. Công ty chuyên phát triển và sản xuất dược phẩm và thuốc không kê đơn cho lĩnh vực điều trị các bệnh về da liễu, sỏi thận... hay các thuốc giảm đau, thuốc nhỏ mắt... Các sản phẩm Rowa được sản xuất theo quy trình áp dụng chính sách đảm bảo chất lượng nghiêm ngặt, cơ sở vật chất của Rowa bao gồm các phòng thí nghiệm hiện đại đáp ứng các tiêu chuẩn công nghệ cao nhất, quy trình đảm bảo chất lượng, cơ sở sản xuất, sản xuất và đóng gói, nhà kho... Các cơ sở của công ty đều phải chịu sự kiểm tra thường xuyên của chính phủ và hoàn toàn được phê duyệt theo tiêu chuẩn CMP. Do vậy các sản phẩm Rowa luôn đạt tiêu chuẩn cao, chất lượng tuyệt vời đáp ứng nhu cầu tại hơn 70 quốc gia trên toàn thế giới'
            ],
            [
                'brand_name' => 'RPG Lifesciences Ltd.',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/rpg-lifesciences-ltd.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Sanofi Others',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/sanofi-others.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Servier International',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/sanofi-others.png',
                'brand_description' => 'Servier là tập đoàn dược phẩm lớn thứ hai của Pháp, thuốc của Servier được kê đơn ở hơn 150 quốc gia. Hơn 20 năm hoạt động tại thị trường Việt Nam, Servier Việt Nam được xếp hạng trong 5 công ty dược phẩm quốc tế hàng đầu, 42% thuốc của Servier được sản xuất và xuất khẩu từ nước Pháp và các loại thuốc này được bào chế với các thành phần chính có nguồn gốc độc quyền tại Pháp. Công ty cung cấp các sản phẩm tiên tiến đa dạng trong các lĩnh vực chủ yếu tim mạch, đái tháo đường, nội khoa, hô hấp.'
            ],
            [
                'brand_name' => 'Shin Poong Daewoo VN',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/shin-poong-daewoo-vn.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Thai Nakorn Patana',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/thai-nakorn-patana.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Yuhan',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/yuhan.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Alaxan',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/alaxan.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Diana',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/diana.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Efferalgan',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/efferalgan.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Excl - Dai Nam',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/excl---dai-nam.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Reckitt Benckiser',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/reckitt-benckiser.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Sao Kim',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/sao-kim.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Cơ sở sản xuất thuốc Y học cổ truyền Bảo Phương',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/co-so-san-xuat-thuoc-y-hoc-co-truyen-bao-phuong.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Công ty TNHH Dược Phẩm Thành Tâm',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Engelhard',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/engelhard.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Farmalabor',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/farmalabor.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Kotra Pharam',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/kotra-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Leopard Medical Brand',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/leopard-medical-brand.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Medana',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/medana.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Medipharco- Tenamyd',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/medipharco-tenamyd.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Merz Pharma – German',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/merz-pharma-german.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Nizoral',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nizoral.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Oxy',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/oxy.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Raptakos Brett',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/raptakos-brett.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Satyam',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/satyam.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Medinova',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/medinova.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Opodis Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/opodis-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Presafe Denmark',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/presafe-denmark.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'BV Pharma',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/bv-pharma.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dopharma',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Hoat Huyet Duong Nao',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/satyam.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Pierre-Fabre',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/pierre-fabre.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Probiotec',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/99_Probiotec.png',
                'brand_description' => 'Được thành lập vào năm 1997, Probiotec xuất xứ thương hiệu ở Úc. Probiotec đã nhanh chóng phát triển trong lĩnh vực sản xuất, tiếp thị và phân phối hàng đầu các loại thuốc kê đơn, thuốc không kê đơn, và các sản phẩm chăm sóc sức khỏe cho người tiêu dùng. Công ty đầu tư rất nhiều vào nghiên cứu, phát triển và trang bị cho các cơ sở sản xuất những công nghệ mới nhất đạt tiêu chuẩn và luôn đảm bảo chất lượng cao nhất cho sản phẩm.'
            ],
            [
                'brand_name' => 'Toni Pharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/toni-pharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Vasoclean',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/vasoclean.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Daewoo',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/daewoo.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Công Ty TNHH Dược Phẩm Thiên Ân',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/cong-ty-tnhh-duoc-pham-thien-an.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Daiichi-Sankyo Co',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/daiichi-sankyo-co.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Ecosip',
                'brand_logo' => null,
                'brand_description' => null
            ],
            [
                'brand_name' => 'Salonpas',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/68_Salonpas.png',
                'brand_description' => 'Salonpas là thương hiệu dược phẩm trị đau nhức bán không cần toa bác sĩ Nhật Bản nổi tiếng thuộc sở hữu của Công ty TNHH Dược Phẩm Hisamitsu. Salonpas ra mắt thị trường Nhật Bản đầu tiên năm 1934, đến nay đã có mặt hơn 30 quốc gia như: Indonesia, Việt Nam, Philippines, Đài Loan,...Vào năm 2008, Salonpas được cơ quan quản lý thực phẩm và thuốc Hoa Kỳ (FDA) cấp giấy phép cho bán. Đây cũng là dược phẩm dầu xức và keo dán giảm đau đầu đầu tiên được bán ở Hoa Kỳ mà không cần toa bác sĩ'
            ],
            [
                'brand_name' => 'Special Products Line S. P. A',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/special-products-line-s-p-a.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'AXE (CAY BUA)',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/axe-cay-bua.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Cao Bach Ho',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/cao-bach-ho.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dau Phat Linh',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dau-phat-linh.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dau Truong Tho',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dau-truong-tho.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'DP & YT Kim Long Mien Nam',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dp-yt-kim-long-mien-nam.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Eagle',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/eagle.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Leung',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/leung.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Siang Pure',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/siang-pure.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Tiger balm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/tiger-balm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Truong Son',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/truong-son.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'An Thao',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/an-thao.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Biocodex',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/biocodex.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Dongkoo Bio & Pharma Co',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/dongkoo-bio-pharma-co.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Duoc pham Ha Noi',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/duoc-pham-ha-noi.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Shine tadeno',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/shine-tadeno.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Bridge Healthcare',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/bridge-healthcare.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Catalent',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/53_catalent.png',
                'brand_description' => 'Catalent được thành lập vào tháng 4 năm 2007, là một tập đoàn đa quốc gia có trụ sở chính tại Mỹ. Đây là nhà cung cấp toàn cầu với công nghệ phân phối, phát triển, sản xuất thuốc, sinh học, liệu pháp gen và các sản phẩm sức khỏe người tiêu dùng. Các cơ sở vật chất hiện đại của Catalent được thiết kế và trang bị để đáp ứng nhu cầu cụ thể của các thực thể sinh học mới, liệu pháp tế bào và gen, thuốc tiêm vô trùng...'
            ],
            [
                'brand_name' => 'Ceelin',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/ceelin.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Enervon',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/enervon.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Hemopoly',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/hemopoly.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'InnotheraChouzy',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/innotherachouzy.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'NIC',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/nic.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Novartis',
                'brand_logo' => 'https://data-service.pharmacity.io/pmc-upload-media/production/pmc-ecm-core/brand-images/18_Novartis.png',
                'brand_description' => 'Novartis là một công ty dược phẩm đa quốc gia có trụ sở chính tại Thụy Sĩ, được thành lập vào năm 1996. Các sản phẩm của Novartis tiếp cận gần 800 triệu người trên toàn thế giới và đang tìm ra những cách sáng tạo để mở rộng khả năng tiếp cận các phương pháp điều trị mới nhất.Novartis AG chuyên về dược phẩm, thuốc generic chất lượng cao và các giải pháp chăm sóc mắt tiên tiến, vắc xin phòng bệnh, thuốc không kê toa,…Novartis đã có mặt tại Việt Nam từ những năm 1950 thông qua hai công ty tiền thân (Sandoz và Ciba-Geigy). Năm 2008, Văn phòng Đại diện của Novartis Pharma Services AG được thành lập. Đầu năm 2020, Công ty TNHH Novartis Việt Nam trở thành công ty dược phẩm đa quốc gia đầu tiên chuyển đổi thành công ty có vốn đầu tư nước ngoài trực thuộc Tập đoàn dược phẩm đa quốc gia Novartis Pharma Services AG (Thụy Sỹ) hoạt động trong lĩnh vực nhập khẩu thuốc.'
            ],
            [
                'brand_name' => 'Usarichpharm',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/usarichpharm.png',
                'brand_description' => null
            ],
            [
                'brand_name' => 'Obimin',
                'brand_logo' => 'https://prod-cdn.pharmacity.io/e-com/images/brand-logo/obimin.png',
                'brand_description' => null
            ]
        ];
        foreach ($data as $index => $brand) {
            try {
                Brand::create($brand);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
