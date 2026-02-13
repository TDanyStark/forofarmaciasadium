# Copilot instructions for this repo

- Framework: CodeIgniter 4 app starter. Web root is public/ with the front controller at public/index.php.
- Routing is defined in app/Config/Routes.php; key endpoints are / (Videos::index), /video/{id}, /registro, /login, /certificado, and /api/video/progress.
- Session auth is lightweight and custom: Registro::checkEmail and Registro::store set session keys isLoggedIn and user (array). Use those keys when adding auth checks. Example: app/Controllers/Registro.php and app/Controllers/Certificado.php.
- Registration validation rules live in the model (getRules on RegistroModel). Prefer that over duplicating rules in controllers. See app/Models/RegistroModel.php.
- Data access is via CodeIgniter Models with allowedFields and table names that map to MySQL tables: videos, video_views, video_progress, video_documents, inscritos. See app/Models/*.php.
- Video flow: Videos::index pulls all videos from DB (no YouTube API), Videos::show logs a view and can insert a certificado eligibility row once the user has watched at least 60% of distinct videos. See app/Controllers/Videos.php.
- Progress tracking: the video page posts every ~30s to /api/video/progress and uses CSRF token meta tags. See app/Views/videos/landing.php and Videos::saveProgress.
- Certificates are generated on demand using FPDI and saved under writable/uploads/certificados/{user_id}/. CertificadoService builds the file name from first/last name and falls back to copying the template PDF if generation fails. See app/Libraries/CertificadoService.php.
- Certificate availability is based on distinct videos viewed; the UI displays progress and a preview iframe. See app/Controllers/Certificado.php and app/Views/certificado/index.php.
- Views use CodeIgniter layout sections. Main layout for auth pages is app/Views/layouts/main.php; the logged-in dashboard layout is app/Views/layouts/dashboardLayout.php.
- Base URL and environment switching live in app/Config/App.php (production URL vs local http://forofarmaciasadium.test/). Update .env when running locally.
- Database defaults in app/Config/Database.php (MySQL, database forofarmaciasadium, port 3307). Tests use the tests group (SQLite memory) by default.
- Testing: run vendor\bin\phpunit (Windows) or composer test; see tests/README.md for coverage and DB setup.
