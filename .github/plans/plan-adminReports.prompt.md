## Plan: Admin Views With Exports

You want a dedicated admin login (separate session keys/role) plus server-rendered admin pages to view inscritos and video views, with CSV export and filters (date range, video, name/email, watched status). The approach is to add an Admin controller and routes, a small admin auth flow, and views that query existing tables (inscritos, videos, video_views, video_progress). We will reuse existing models where possible and add focused query methods if needed. We will also add a CSV export endpoint(s) for the selected lists, keeping the UI in a new admin layout or an extension of the dashboard layout. Filters will be implemented as query params across list and export endpoints so downloads match the on-screen data.

**Steps**
1. Define admin routes and controller skeletons: add routes for admin login, admin dashboard, inscritos list, per-video view list, and CSV exports in app/Config/Routes.php; create an Admin controller (e.g., `Admin::login`, `Admin::authenticate`, `Admin::logout`, `Admin::inscritos`, `Admin::videoViews`, `Admin::exportInscritos`, `Admin::exportVideoViews`) in app/Controllers.
2. Add an admin auth guard: create a new filter (e.g., `AdminAuth`) that checks separate session keys, modeled after app/Filters/Auth.php, and register it in app/Config/Filters.php; store admin session keys in the admin login flow.
3. Build admin login view and layout: add views under app/Views (e.g., `admin/login.php`, `layouts/adminLayout.php`); keep styles consistent with existing layouts in app/Views/layouts/dashboardLayout.php or define a lean admin look.
4. Add query methods for reporting: extend or add model methods in app/Models/RegistroModel.php, app/Models/VideoViewModel.php, and possibly app/Models/VideoProgressModel.php to support filters (date range, video, user search, watched status), joining `inscritos`, `videos`, and `video_views` as needed; keep logic in models to avoid heavy controller queries.
5. Implement admin list views: create `admin/inscritos.php` (per-user with watched videos and timestamps) and `admin/video_views.php` (per-video with users who watched) in app/Views; add filter forms that map to query params and feed the model queries.
6. Implement CSV export endpoints: add `Admin::exportInscritos` and `Admin::exportVideoViews` to output CSV with headers and filtered results; reuse the same filter parsing logic as the list views to keep data consistent.
7. Navigation updates: add admin links in a suitable place (e.g., a minimal admin navbar inside the admin layout) without affecting public/dashboard navigation in app/Views/layouts/dashboardLayout.php.

**Verification**
- Manual: log in via admin login, hit each list page, verify filters and results; download CSV and confirm content matches filtered view.
- Data sanity: compare per-user and per-video lists for consistency on a sample record.

**Decisions**
- Separate admin login with its own session keys and filter.
- CSV export only (no XLSX/PDF for now).
- MVP includes inscritos list with per-user views + timestamps and per-video view list, with date, video, name/email, and watched filters.
