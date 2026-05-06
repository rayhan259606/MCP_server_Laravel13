# Blade Voice AI System Documentation

এটি একটি লারাভেল (Laravel) ভিত্তিক ভয়েস অ্যাসিস্ট্যান্ট সিস্টেম যা এআই (AI) এবং ভয়েস কমান্ডের মাধ্যমে ওয়েবসাইট কন্ট্রোল করতে পারে।

## ১. সিস্টেম আর্কিটেকচার (System Architecture)
সিস্টেমটি মূলত তিনটি স্তরে কাজ করে:
- **Frontend:** Blade, CSS (Premium Glassmorphism), and JavaScript (SpeechRecognition API).
- **AI Engine:** OpenRouter (Gemini Flash) ব্যবহার করে ন্যাচারাল ল্যাঙ্গুয়েজ প্রসেস করা হয়।
- **Backend:** Laravel Controller and Service layer যা টুল এক্সিকিউট করে।

## ২. ডাটা ফ্লো (Data Flow)
আপনি যখন ভয়েস কমান্ড দেন, তখন ডাটা নিচের পথে প্রবাহিত হয়:
১. **ইউজার ভয়েস** -> ব্রাউজারের মাধ্যমে **টেক্সট** এ রূপান্তর।
২. **জাভাস্ক্রিপ্ট** -> টেক্সটটি `/ai-process` এন্ডপয়েন্টে পাঠায়।
৩. **MCPController** -> রিকোয়েস্ট গ্রহণ করে এবং `AIService` কে দিয়ে প্রসেস করায়।
৪. **AIService (OpenRouter)** -> ইউজারের ইনটেন্ট (Intent) বুঝে একটি JSON অবজেক্ট রিটার্ন করে (যেমন: কোন টুল চালাতে হবে)।
৫. **MCPService** -> AI এর নির্দেশ অনুযায়ী ডাটাবেজ অপারেশন (Create, List, Memory) সম্পন্ন করে।
৬. **Response** -> সার্ভার থেকে জাভাস্ক্রিপ্টে রেজাল্ট ফিরে আসে এবং ব্রাউজার সেটি ভয়েস (TTS) এর মাধ্যমে শোনায়।

## ৩. মূল ফিচারসমূহ (Core Features)
- **Navigation:** ভয়েস কমান্ড দিয়ে পেজ পরিবর্তন করা।
- **Form Automation:** ফর্ম অটো-ফিল এবং ভয়েস কমান্ডে সাবমিট করা।
- **Data Display:** ডাটাবেজের সকল তথ্য একটি প্রিমিয়াম প্যানেলে দেখানো।
- **AI Memory:** ইউজারের কথা মনে রাখা এবং পরে তা পুনরায় বলা।

## ৪. ভয়েস কমান্ড গাইড (Voice Command Guide)

### পেজ নেভিগেশন (Navigation)
| কমান্ড (English) | কমান্ড (Bengali) | কাজ |
| :--- | :--- | :--- |
| Go to Login / Open Login | লগইন পেজে যাও | লগইন পেজে নিয়ে যাবে |
| Go to Register | রেজিস্ট্রেশন পেজে যাও | নতুন একাউন্ট খোলার পেজে যাবে |
| Go to Career | ক্যারিয়ার পেজে যাও | ক্যারিয়ার পেজে নিয়ে যাবে |
| Go Home | হোম পেজে চলো | মেইন ড্যাশবোর্ডে ফিরে যাবে |

### অটোমেশন ও ডাটা (Automation & Data)
| কমান্ড (English) | কমান্ড (Bengali) | কাজ |
| :--- | :--- | :--- |
| Fill the form / Popluate data | ফর্ম পূরণ করো | ফর্মের ডেমো ডাটা বসিয়ে দেবে |
| Register now / Submit form | সাবমিট করো / রেজিস্টার করো | ডাটাবেজে ইউজার সেভ করবে |
| Show all data / List users | সব ডাটা দেখাও | ডাটাবেজের ইউজার লিস্ট দেখাবে |

### মেমোরি (Memory)
| কমান্ড (English) | কমান্ড (Bengali) | কাজ |
| :--- | :--- | :--- |
| Remember that [info] | মনে রাখো যে [তথ্য] | তথ্যটি ডাটাবেজে সেভ করে রাখবে |
| What did I tell you before? | আমি আগে কী বলেছিলাম? | সেভ করা মেমোরি শোনাবে |

## ৫. ফাইল স্ট্রাকচার (Key Files)
- `resources/views/layouts/app.blade.php`: মাস্টার লেআউট এবং ভয়েস লজিক।
- `app/Services/AIService.php`: ওপেন-রাউটার এআই ইন্টিগ্রেশন।
- `app/Services/MCPService.php`: ব্যাকএন্ড টুল লজিক।
- `app/Http/Controllers/MCPController.php`: এপিআই হ্যান্ডলার।
- `routes/web.php`: সকল ইউআরএল রুট।

---

**ADD api key in env file **
*Documentation Created on: 2026-05-06*
