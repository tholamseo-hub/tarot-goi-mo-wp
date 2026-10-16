# Moonlit Tarot — demo web Tarot tương tác

Một mẫu landing page / web app tiếng Việt lấy cảm hứng từ mô hình website Tarot như Stick Tarot. Đây là bản triển khai độc lập, không phải source code gốc, không sao chép thương hiệu, hình ảnh hay nội dung độc quyền.

## Chạy thử

- Giải nén và mở `index.html` bằng trình duyệt hiện đại. Không cần Node, build, cơ sở dữ liệu hoặc API key.
- Hoặc mở terminal tại thư mục và chạy `python -m http.server 8080`, truy cập `http://localhost:8080`.
- Có thể upload ba file `index.html`, `styles.css`, `app.js` lên Cloudflare Pages dạng static assets.

## Có sẵn

- Landing page responsive desktop / mobile, menu mobile, FAQ.
- Trải Tarot 3 lá: nhập câu hỏi, gợi ý, xáo bài, tự chọn hoặc chọn ngẫu nhiên, lật và đọc diễn giải theo ba vị trí.
- Bộ 22 thẻ Tarot diễn giải mẫu, không phụ thuộc thư viện bên ngoài.
- Chat nối tiếp bằng phản hồi có quy tắc, chỉ để minh họa (không phải AI thật).
- Danh mục Reader minh họa: lọc theo chủ đề, thử chọn lịch trong modal (không thực hiện booking thật).
- Không lưu câu hỏi lên server, không thu thập thông tin cá nhân, không tích hợp thanh toán.

## Nâng cấp lên bản production

1. API backend (Cloudflare Worker hoặc Node.js) cho AI thật; đặt API key trong secret trên server, không đưa key vào JS frontend.
2. Dữ liệu Reader, lịch trống và booking được kiểm tra ở backend, kèm xác thực và quy tắc bảo mật.
3. Trang quản trị và dữ liệu được người dùng đồng ý lưu, điều khoản và chính sách bảo mật.
4. Thay card SVG/CSS demo bằng bộ art được cấp phép hoặc hình tự thiết kế.
5. Tùy chọn self-host font nếu không muốn gọi Google Fonts.

## Lưu ý

Tarot ở đây được trình bày như công cụ chiêm nghiệm, không phải lời tiên tri hoặc lời khuyên chuyên môn. Các nhân vật Reader đều là mẫu minh họa. Website demo không liên kết hoặc đại diện cho Stick Tarot.