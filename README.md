# IBBDev - منصة تبادل الخبرات البرمجية

منصة ويب لتبادل الأسئلة البرمجية بين طلاب علوم الحاسوب، مبنية بـ Laravel 13.

---

## 📖 عن المشروع

**IBBDev** هو مشروع المعمل الخامس لمادة **هندسة البرمجيات** في **جامعة إب**.

يهدف المشروع إلى توفير مكان واحد موحد لتبادل الخبرات البرمجية بين الطلاب، بدلاً من تشتت الأسئلة بين مجموعات التواصل الاجتماعي.

تتيح المنصة للطالب:
- طرح سؤال برمجي مع صورة توضيحية
- الإجابة على أسئلة زملائه
- اعتماد الإجابة الصحيحة
- الحصول على نقاط سمعة

---

## ✨ الميزات

### إدارة الحسابات
- إنشاء حساب باسم مستخدم فريد
- رفع صورة شخصية (اختيارية)
- تسجيل الدخول والخروج
- عرض نقاط السمعة

### نظام الأسئلة
- طرح سؤال برمجي مع عنوان ونص
- رفع صورة توضيحية (اختيارية)
- عرض الأسئلة مرتبة من الأحدث
- عرض عدد الإجابات لكل سؤال

### نظام الإجابات
- الإجابة على أسئلة الآخرين
- منع الإجابة على السؤال الخاص
- اعتماد إجابة كحل صحيح
- تمييز الإجابة المعتمدة بإطار أخضر

### نظام النقاط
- صاحب الإجابة المعتمدة يحصل على 10 نقاط
- زيادة فورية عند الاعتماد
- عرض النقاط في الشريط العلوي

### الأمان
- تشفير كلمات المرور
- منع غير صاحب السؤال من الاعتماد (403)
- التحقق من صحة جميع المدخلات
- حماية CSRF على جميع النماذج

---

## 🏗️ المعمارية

المشروع مبني وفق **MVC + Service Layer**:

```
المتصفح
   │
   ▼
Routes (web.php)
   │
   ▼
Form Request (تحقق من الإدخال)
   │
   ▼
Controller (نحيف - يستقبل الطلب فقط)
   │
   ▼
Service (منطق الأعمال) ← يعتمد على Interface
   │
   ▼
Model / Eloquent → Database
   │
   ▼
Blade View → HTML للمستخدم
```

**القاعدة الذهبية:** الـ Controller لا يكتب أي منطق أعمال بنفسه، فقط يستدعي Service عبر Interface (Dependency Injection).

---

## 🧩 المفاهيم المطبقة

| المفهوم | مكان التطبيق | المعمل |
|---------|--------------|--------|
| Git Workflow | فرع lab5-ibbdev + Pull Request | 1 |
| MVC / CRUD | Controllers + Blade + Form Requests | 2 |
| OOP + العلاقات | Models + One-to-Many | 3 |
| SOLID (SRP + DIP) | Service Layer + Interfaces | 4 |
| Policies | AnswerPolicy | 4 |
| الهندسة المتكاملة | تطبيق حقيقي كامل | 5 |

---

## 🗄️ قاعدة البيانات

### الجداول

#### جدول users

| العمود | النوع | الوصف |
|--------|-------|--------|
| id | bigint | المفتاح الأساسي |
| name | string | الاسم الكامل |
| username | string unique | اسم المستخدم الفريد |
| email | string unique | البريد الإلكتروني |
| password | string | كلمة المرور المشفرة |
| avatar | string nullable | مسار الصورة الشخصية |
| reputation_points | integer | نقاط السمعة (افتراضي 0) |
| timestamps | datetime | تواريخ الإنشاء والتحديث |

#### جدول questions

| العمود | النوع | الوصف |
|--------|-------|--------|
| id | bigint | المفتاح الأساسي |
| user_id | foreignId | معرف صاحب السؤال (CASCADE) |
| title | string | عنوان السؤال |
| body | text | نص السؤال |
| image | string nullable | مسار صورة الخطأ |
| timestamps | datetime | تواريخ الإنشاء والتحديث |

#### جدول answers

| العمود | النوع | الوصف |
|--------|-------|--------|
| id | bigint | المفتاح الأساسي |
| question_id | foreignId | معرف السؤال (CASCADE) |
| user_id | foreignId | معرف صاحب الإجابة (CASCADE) |
| body | text | نص الإجابة |
| is_accepted | boolean | هل تم اعتمادها؟ (افتراضي false) |
| timestamps | datetime | تواريخ الإنشاء والتحديث |

### العلاقات

```
User ──(1:N)──> Question ──(1:N)──> Answer
  │                                    ▲
  └──────────────(1:N)─────────────────┘
```

- مستخدم واحد → عدة أسئلة
- مستخدم واحد → عدة إجابات
- سؤال واحد → عدة إجابات

---

## 📁 هيكل المشروع

```
IbbDev_WebSite/
├── app/
│   ├── Contracts/
│   │   ├── QuestionServiceInterface.php
│   │   ├── AnswerServiceInterface.php
│   │   └── ReputationServiceInterface.php
│   ├── Services/
│   │   ├── QuestionService.php
│   │   ├── AnswerService.php
│   │   └── ReputationService.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Question.php
│   │   └── Answer.php
│   ├── Policies/
│   │   └── AnswerPolicy.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── QuestionController.php
│   │   │   └── AnswerController.php
│   │   └── Requests/
│   │       ├── StoreQuestionRequest.php
│   │       └── StoreAnswerRequest.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   └── migrations/
├── resources/views/
│   ├── layouts/app.blade.php
│   └── questions/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── show.blade.php
└── routes/
    └── web.php
```

---

## 🛠️ المتطلبات

| المتطلب | الإصدار |
|---------|---------|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| PostgreSQL | 14+ |
| Laravel | 13.x |

---

## 🚀 التثبيت والتشغيل

### 1. استنساخ المشروع

```bash
git clone https://github.com/abdalrhmnalyfrsy/IbbDev_WebSite.git
cd IbbDev_WebSite
```

### 2. تثبيت الاعتماديات

```bash
composer install
npm install
```

### 3. إعداد ملف البيئة

```bash
cp .env.example .env
php artisan key:generate
```

### 4. إعداد قاعدة البيانات

عدّل ملف `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ibbdev
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

أنشئ قاعدة البيانات في pgAdmin:

```sql
CREATE DATABASE ibbdev;
```

### 5. تنفيذ الترحيلات

```bash
php artisan migrate
```

### 6. ربط التخزين

```bash
php artisan storage:link
```

### 7. تجميع الأصول

```bash
npm run build
```

### 8. تشغيل الخادم

```bash
php artisan serve
```

افتح المتصفح على: `http://localhost:8000`

---

## 🧪 الاختبار اليدوي

| # | السيناريو | النتيجة المتوقعة | الحالة |
|---|-----------|------------------|--------|
| 1 | إنشاء حساب باسم مستخدم فريد | نجاح | ✅ |
| 2 | محاولة إنشاء حساب بنفس username | رفض | ✅ |
| 3 | تسجيل الدخول والخروج | يعمل | ✅ |
| 4 | طرح سؤال بدون صورة | نجاح | ✅ |
| 5 | طرح سؤال مع صورة | تظهر الصورة | ✅ |
| 6 | الإجابة على سؤال شخص آخر | نجاح | ✅ |
| 7 | الإجابة على سؤالك الخاص | رفض برسالة واضحة | ✅ |
| 8 | اعتماد إجابة من صاحب السؤال | زيادة 10 نقاط | ✅ |
| 9 | اعتماد إجابة من غير صاحب السؤال | صفحة 403 | ✅ |

---

## 🔐 الصلاحيات (Policies)

### AnswerPolicy

- **من يستطيع اعتماد إجابة؟** صاحب السؤال فقط
- **ماذا يحدث للمخالف؟** صفحة 403 Forbidden

---

## 💡 أمثلة على منطق الأعمال

### QuestionService

عند إنشاء سؤال:
- إذا وُجدت صورة، تخزن في `storage/app/public/questions`
- يتم حفظ مسار الصورة في قاعدة البيانات

### AnswerService

قبل حفظ الإجابة:

```php
if ($question->user_id === $user->id) {
    throw ValidationException::withMessages([
        'body' => 'لا يمكنك الإجابة على سؤالك الخاص.',
    ]);
}
```

### ReputationService

عند اعتماد الإجابة:

```php
$answer->update(['is_accepted' => true]);
$answer->user()->increment('reputation_points', 10);
```

---

## 🎯 تدفق الاستخدام

### زيارة الصفحة الرئيسية
- عرض جميع الأسئلة من الأحدث للأقدم
- بجانب كل سؤال: العنوان، صاحب السؤال، عدد الإجابات

### عرض سؤال
- تفاصيل السؤال (العنوان، النص، الصورة)
- جميع الإجابات
- إذا كنت صاحب السؤال: زر "اعتماد كحل" بجانب كل إجابة
- إذا لم تكن مسجلاً: رابط "سجّل دخولك"
- إذا كنت مسجلاً وليس سؤالك: مربع لكتابة إجابة

### اعتماد إجابة
- تتحول الإجابة إلى إطار أخضر
- تزيد نقاط صاحبها بـ 10
- تظهر رسالة نجاح

---

## 👨‍💻 المطور

**عبدالرحمن اليفرسي** (Abdulrrhman alyafrasi)

- 🎓 جامعة إب - Ibb University
- 📚 كلية الحاسبات - المستوى الرابع
- 💼 هندسة البرمجيات - المعمل الخامس
- 📧 abdalrhmnalyfrsy@gmail.com
- 🐙 GitHub: [@abdalrhmnalyfrsy](https://github.com/abdulrrhman-alyafrasi-dev)

---

## 📄 الترخيص

هذا المشروع تم بناؤه لأغراض تعليمية ضمن متطلبات مادة هندسة البرمجيات في جامعة إب.

---

**🌟 شكراً لكم 🌟**