# Tarot Gợi Mở trên Flatsome

## Kiến trúc

- `themes/tarot-goi-mo/`: theme custom cũ, giữ nguyên để rollback trong giai đoạn chuyển đổi.
- `themes/tarot-goi-mo-flatsome-child/`: child theme mới, yêu cầu theme cha `flatsome`.
- `plugins/tarot-goi-mo-core/`: plugin độc lập chứa 22 lá Tarot, logic rút bài, shortcode và giao diện widget.

Không đưa mã nguồn Flatsome vào repository. Flatsome phải được cài riêng bằng bản quyền của chủ website.

## Shortcode dành cho UX Builder

Trong Flatsome UX Builder, thêm element **Shortcode** và dùng:

- `[tarot_goi_mo_draw]` — khu rút một lá + lời giải.
- `[tarot_goi_mo_arcana]` — thư viện 22 lá Ẩn Chính.
- `[tarot_goi_mo]` — hiển thị cả hai liên tiếp.

Khuyến nghị dùng hai shortcode riêng để có thể chèn banner, heading, khoảng cách, CTA hoặc section khác giữa hai phần bằng UX Builder.

## Chỉnh sửa nội dung 22 lá

Sau khi plugin `Tarot Gợi Mở Core` được kích hoạt, WordPress Admin sẽ có menu **Tarot Gợi Mở**.

Mỗi lá có thể sửa trực tiếp:

- Tên Việt (title WordPress)
- Số / La Mã
- Tên tiếng Anh
- Từ khóa
- Tổng quan
- Tình cảm
- Công việc
- Tài chính
- Nội tâm
- Khi đảo ngược
- Lời nhắc

Lần kích hoạt đầu tiên, plugin sẽ thử import 22 lá từ theme custom cũ tại `wp-content/themes/tarot-goi-mo/assets/data/major-arcana.php`. Sau khi import, dữ liệu nằm trong database và không còn phụ thuộc theme cũ.

## Trình tự chuyển site an toàn

1. Cài Flatsome parent theme, nhưng chưa kích hoạt child theme mới.
2. Cài `Tarot Gợi Mở Core` và kích hoạt plugin để import 22 lá.
3. Cài `Tarot Gợi Mở — Flatsome Child`.
4. Tạo một trang thử nghiệm bằng UX Builder và chèn shortcode Tarot.
5. QA desktop/mobile.
6. Chỉ khi trang thử nghiệm ổn mới kích hoạt child theme và đặt trang đó làm Homepage.
7. Giữ theme custom cũ trong vài ngày làm rollback; không xóa ngay.

## Quyền chỉnh sửa về sau

- Bố cục, banner, heading, màu section, spacing, mobile layout: UX Builder / Flatsome Theme Options.
- Nội dung từng lá Tarot: WordPress Admin > Tarot Gợi Mở.
- Logic rút bài và giao diện widget: plugin trong GitHub.
