# Module Lì xì - NukeViet CMS

Module lì xì ảo cho NukeViet CMS 4.x. Cho phép tạo sự kiện lì xì, bốc lì xì và theo dõi lịch sử.

## Cài đặt

1. Copy các thư mục và file vào thư mục gốc của NukeViet:
   - `modules/lixi` → `NukeViet/modules/`
   - `themes/default/modules/lixi` → `NukeViet/themes/default/modules/`
   - `themes/default/css/lixi.css` → `NukeViet/themes/default/css/`
   - `themes/admin_default/modules/lixi` → `NukeViet/themes/admin_default/modules/`

2. Vào **Quản trị** → **Modules** → Cài đặt module "Lì xì"

3. Kích hoạt module

## Tính năng

- **Trang chủ:** Danh sách sự kiện đang mở, thống kê, bảng xếp hạng
- **Tạo sự kiện:** Form tạo (tiêu đề, mô tả, số phong bì, loại cố định/ngẫu nhiên)
- **Bốc lì xì:** Form nhập thông tin → nhận số tiền
- **Sự kiện của tôi:** Danh sách sự kiện do mình tạo (cần đăng nhập)
- **Lịch sử:** Lịch sử đã bốc lì xì (cần đăng nhập)
- **Bảng xếp hạng:** Top người nhận nhiều nhất
- **Admin:** Quản lý sự kiện, xem người tham gia, export CSV

## Yêu cầu

- NukeViet 4.x
- PHP 7.0+
- MySQL

## URL

- Trang chủ: `?nv=lixi`
- Tạo sự kiện: `?nv=lixi&op=create`
- Bốc lì xì: `?nv=lixi&op=join&alias=xxx`
- Chi tiết: `?nv=lixi&op=detail&alias=xxx`
