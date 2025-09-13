# 🎬 Hireflix - Professional Video Interview Platform

<div align="center">

![Hireflix Logo](https://img.shields.io/badge/Hireflix-Video%20Interview%20Platform-blue?style=for-the-badge&logo=video&logoColor=white)

**A modern, feature-rich video interview application built with Laravel & MySQL**

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)

</div>

---

## 🌟 **What is Hireflix?**

Hireflix is a comprehensive **one-way video interview platform** that revolutionizes the hiring process. It enables companies to create structured interviews with multiple question types and allows candidates to submit responses at their convenience, including **real-time video recordings**.

### 🎯 **Perfect For:**
- **HR Teams** conducting initial screening interviews
- **Remote Companies** hiring globally distributed talent  
- **Educational Institutions** for admissions interviews
- **Recruitment Agencies** streamlining candidate evaluation

---

## ✨ **Core Features**

### 🔐 **Advanced Authentication System**
- **Dual Role Architecture**: Admin/Reviewer and Candidate roles
- **Secure Registration**: Email-based account creation
- **Session Management**: Persistent login with role-based access
- **Password Security**: Encrypted password storage
- **Role-Based Permissions**: Different interfaces for different user types

### 📋 **Comprehensive Interview Management**

#### **For Administrators:**
- **Interview Creation Wizard**: Step-by-step interview setup
- **Question Type Variety**: 4 different response formats
- **Bulk Question Management**: Add, edit, remove questions dynamically
- **Interview Templates**: Reusable interview structures
- **Real-time Preview**: See how candidates will view questions

#### **Question Types Available:**
1. **📝 Text Response**
   - Open-ended written answers
   - Rich text input with validation
   - Character count and formatting

2. **🎥 Video Response**
   - Browser-based video recording
   - WebRTC technology (no plugins needed)
   - Real-time preview and playback
   - Automatic compression and storage

3. **☑️ Multiple Choice Questions**
   - Unlimited custom options
   - Visual card-based selection
   - Letter-based labeling (A, B, C, D...)
   - Selected option highlighting

4. **⭐ Rating Scale (1-10)**
   - Interactive circular rating buttons
   - Descriptive labels (Poor, Average, Excellent, Perfect)
   - Visual feedback on selection
   - Hover effects and animations

### 👤 **Enhanced Candidate Experience**

#### **Interview Dashboard:**
- **Clean Interface**: Modern, intuitive design
- **Interview Status**: Track completed vs pending interviews
- **Progress Indicators**: Visual completion status
- **Responsive Design**: Works on desktop, tablet, and mobile

#### **Question Interaction:**
- **Auto-save Functionality**: Responses saved as you type
- **Media Controls**: Professional video recording interface
- **Visual Feedback**: Clear indication of selected answers
- **Form Validation**: Real-time input validation

#### **Submission Process:**
- **Review Before Submit**: Preview all answers
- **AJAX Submission**: Handles large video files seamlessly
- **Confirmation System**: Success notifications
- **Response Viewing**: See your submitted answers

### 🔍 **Professional Admin Review System**

#### **Submission Management:**
- **Candidate Overview**: Complete submission dashboard
- **Filtering Options**: Sort by date, score, completion status
- **Bulk Actions**: Mass review and scoring capabilities
- **Export Functionality**: Download submission reports

#### **Detailed Review Interface:**
- **Question Context**: Full question display with options
- **Response Highlighting**: Clear candidate answer presentation
- **Video Playback**: Integrated video player with controls
- **MCQ Visualization**: Options with selected choice highlighted
- **Rating Display**: Visual representation of candidate ratings

#### **Scoring System:**
- **0-100 Scale**: Standardized scoring system
- **Comment System**: Detailed feedback for each candidate
- **Score Analytics**: Performance tracking and insights
- **Review History**: Track scoring changes over time

---

## 🎨 **UI/UX Features**

### **Modern Design System:**
- **Tailwind CSS**: Utility-first CSS framework
- **Responsive Layout**: Mobile-first design approach
- **Dark/Light Themes**: Consistent color schemes
- **Font Awesome Icons**: Professional iconography
- **Smooth Animations**: CSS transitions and hover effects

### **Interactive Elements:**
- **Card-based Layout**: Clean, organized content presentation
- **Button States**: Hover, active, and disabled states
- **Form Controls**: Custom-styled inputs and selectors
- **Progress Indicators**: Visual feedback for user actions
- **Modal Dialogs**: Contextual information display

### **Accessibility Features:**
- **Keyboard Navigation**: Full keyboard accessibility
- **Screen Reader Support**: ARIA labels and descriptions
- **Color Contrast**: WCAG compliant color schemes
- **Focus Indicators**: Clear focus states for all interactive elements

---

## 🛠 **Technical Architecture**

### **Backend Stack:**
```
🔧 PHP 8.2          - Modern PHP with latest features
🚀 Laravel 10       - Robust MVC framework
🗄️ MySQL 8.0        - Reliable relational database
🔒 Laravel Sanctum  - API authentication
📧 Mail System      - Email notifications
🔐 Bcrypt Hashing   - Secure password encryption
```

### **Frontend Technologies:**
```
🎨 Blade Templates  - Server-side rendering
💨 Tailwind CSS     - Utility-first styling
📱 Responsive Grid  - Mobile-first layout
🎭 Font Awesome     - Icon library
🎬 WebRTC API       - Video recording
📊 Chart.js         - Data visualization
```

### **Infrastructure:**
```
🐳 Docker           - Containerization
🔄 Docker Compose   - Multi-container orchestration
🌐 Nginx            - Web server
📦 Composer         - PHP dependency management
🔧 Artisan CLI      - Laravel command-line tools
```

### **Database Schema:**
```sql
📊 Users Table      - Authentication and roles
📋 Interviews       - Interview definitions
❓ Questions        - Question content and types
📝 Submissions      - Candidate responses
🎥 Video Storage    - Base64 encoded videos
⭐ Scores           - Review and feedback data
```

---

## 🚀 **Complete Setup Guide**

### **Prerequisites Checklist:**
- [ ] **Docker Desktop** installed and running
- [ ] **Docker Compose** v2.0+ available
- [ ] **Git** for version control
- [ ] **Modern Browser** (Chrome, Firefox, Safari, Edge)
- [ ] **Microphone/Camera** for video recording testing

### **Step 1: Environment Setup**

```bash
# Clone or navigate to project directory
cd /opt/hireflix

# Verify Docker is running
docker --version
docker-compose --version
```

### **Step 2: Application Startup**

```bash
# Start all services in background
docker-compose up -d

# Verify containers are running
docker-compose ps
```

**Expected Output:**
```
NAME                COMMAND             SERVICE             STATUS
hireflix_app_1      "docker-php-entrypoint"  app            Up
hireflix_db_1       "docker-entrypoint.s..."  db             Up
```

### **Step 3: Application Configuration**

```bash
# Install PHP dependencies
docker-compose exec app composer install

# Generate application encryption key
docker-compose exec app php artisan key:generate

# Run database migrations
docker-compose exec app php artisan migrate

# Set proper permissions
docker-compose exec app chmod -R 755 storage bootstrap/cache
```

### **Step 4: Verification**

1. **Open Browser**: Navigate to `http://localhost:8000`
2. **Check Homepage**: Should see Hireflix welcome page
3. **Test Registration**: Try creating an account
4. **Verify Database**: Ensure user creation works

---

## 👥 **Complete User Guide**

### **🔧 Admin Workflow**

#### **1. Initial Setup**
```
📝 Register Admin Account
   ↓
🎯 Create First Interview  
   ↓
❓ Add Multiple Question Types
   ↓
✅ Publish Interview
```

#### **2. Interview Creation Process**
1. **Basic Information**
   - Interview title and description
   - Target role or position
   - Estimated completion time

2. **Question Design**
   - Choose question types strategically
   - Write clear, concise questions
   - Set up MCQ options thoughtfully
   - Configure rating scales appropriately

3. **Review and Publish**
   - Preview candidate experience
   - Test all question types
   - Activate interview for candidates

#### **3. Candidate Management**
- **Monitor Submissions**: Real-time submission tracking
- **Review Responses**: Comprehensive evaluation interface
- **Score Candidates**: Standardized 0-100 scoring
- **Provide Feedback**: Detailed comments and notes

### **👤 Candidate Workflow**

#### **1. Getting Started**
```
📧 Receive Interview Invitation
   ↓
🔐 Register Candidate Account
   ↓
📋 Access Available Interviews
   ↓
🎯 Complete Interview Questions
```

#### **2. Interview Completion**
1. **Preparation**
   - Test camera and microphone
   - Find quiet, well-lit environment
   - Review interview requirements

2. **Question Response**
   - Read questions carefully
   - Record video responses professionally
   - Select MCQ options thoughtfully
   - Provide honest ratings

3. **Submission**
   - Review all responses
   - Submit completed interview
   - Receive confirmation

---

## 🎯 **Advanced Features**

### **Video Recording System**
- **WebRTC Integration**: Direct browser recording
- **Automatic Compression**: Optimized file sizes
- **Base64 Storage**: Secure video data handling
- **Playback Controls**: Professional video player
- **Cross-browser Support**: Works on all modern browsers

### **Real-time Form Handling**
- **AJAX Submissions**: Seamless form processing
- **Large File Support**: Handles video data efficiently
- **Auto-save**: Prevents data loss
- **Validation**: Real-time input checking

### **Security Implementation**
- **CSRF Protection**: All forms protected
- **SQL Injection Prevention**: Parameterized queries
- **XSS Protection**: Input sanitization
- **Role-based Access**: Secure route protection
- **Password Hashing**: Bcrypt encryption

---

## 🔧 **Development & Customization**

### **Local Development Setup**
```bash
# Access application container
docker-compose exec app bash

# Run Laravel commands
php artisan make:controller CustomController
php artisan make:model CustomModel
php artisan make:migration create_custom_table

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### **Database Management**
```bash
# Reset database completely
docker-compose exec app php artisan migrate:fresh

# Seed with sample data
docker-compose exec app php artisan db:seed

# Create new migration
docker-compose exec app php artisan make:migration add_custom_field
```

### **Customization Options**
- **Styling**: Modify Tailwind CSS classes
- **Question Types**: Add new response formats
- **Scoring System**: Implement custom scoring logic
- **Email Templates**: Customize notification emails
- **Dashboard Widgets**: Add analytics and reporting

---

## 📊 **Performance & Scalability**

### **Optimization Features**
- **Database Indexing**: Optimized query performance
- **Lazy Loading**: Efficient data retrieval
- **Caching System**: Redis-ready architecture
- **Asset Optimization**: Minified CSS/JS
- **Image Compression**: Optimized media handling

### **Scalability Considerations**
- **Horizontal Scaling**: Load balancer ready
- **Database Clustering**: MySQL replication support
- **CDN Integration**: Static asset distribution
- **Queue System**: Background job processing
- **Monitoring**: Application performance tracking

---

## 🆘 **Troubleshooting Guide**

### **Common Issues & Solutions**

#### **🎥 Video Recording Problems**
```
❌ Camera not detected
✅ Check browser permissions
✅ Ensure HTTPS in production
✅ Test with different browsers

❌ Video not saving
✅ Check file size limits
✅ Verify storage permissions
✅ Monitor browser console for errors
```

#### **🔐 Authentication Issues**
```
❌ Login not working
✅ Clear browser cache
✅ Check database connection
✅ Verify user credentials

❌ Registration failing
✅ Check email uniqueness
✅ Verify form validation
✅ Monitor server logs
```

#### **🐳 Docker Problems**
```
❌ Containers not starting
✅ Check Docker daemon status
✅ Verify port availability
✅ Review docker-compose.yml

❌ Database connection failed
✅ Wait for MySQL initialization
✅ Check environment variables
✅ Restart containers
```

### **Debug Commands**
```bash
# Check application logs
docker-compose logs -f app

# Monitor database logs
docker-compose logs -f db

# Access MySQL directly
docker-compose exec db mysql -u root -p

# Check container status
docker-compose ps
```

---

## 🚀 **Production Deployment**

### **Production Checklist**
- [ ] **SSL Certificate**: HTTPS configuration
- [ ] **Environment Variables**: Secure .env setup
- [ ] **Database Backup**: Automated backup system
- [ ] **Monitoring**: Application performance tracking
- [ ] **Logging**: Centralized log management
- [ ] **Security**: Firewall and access controls

### **Deployment Options**
- **Cloud Platforms**: AWS, Google Cloud, Azure
- **VPS Hosting**: DigitalOcean, Linode, Vultr
- **Container Orchestration**: Kubernetes, Docker Swarm
- **CI/CD Pipeline**: GitHub Actions, GitLab CI

---

## 📈 **Analytics & Reporting**

### **Built-in Metrics**
- **Interview Completion Rates**: Track candidate engagement
- **Response Time Analytics**: Monitor completion duration
- **Question Performance**: Identify effective questions
- **Scoring Distribution**: Analyze candidate performance
- **User Activity**: Track system usage patterns

### **Export Capabilities**
- **CSV Reports**: Submission data export
- **PDF Generation**: Interview summaries
- **API Endpoints**: Custom integrations
- **Database Queries**: Direct data access

---

## 🤝 **Contributing & Support**

### **Development Contribution**
1. **Fork Repository**: Create your own copy
2. **Feature Branch**: `git checkout -b feature/amazing-feature`
3. **Commit Changes**: `git commit -m 'Add amazing feature'`
4. **Push Branch**: `git push origin feature/amazing-feature`
5. **Pull Request**: Submit for review

### **Bug Reports**
- **GitHub Issues**: Detailed bug reports
- **Error Logs**: Include relevant log files
- **Environment Info**: System specifications
- **Reproduction Steps**: Clear instructions

### **Feature Requests**
- **Use Case Description**: Explain the need
- **Implementation Ideas**: Suggest approaches
- **Priority Level**: Indicate importance
- **User Impact**: Describe benefits

---

## 📄 **License & Legal**

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

### **Third-party Licenses**
- **Laravel Framework**: MIT License
- **Tailwind CSS**: MIT License
- **Font Awesome**: Font Awesome Free License
- **Docker**: Apache License 2.0

---

<div align="center">

## 🎬 **Ready to Transform Your Hiring Process?**

**Start conducting professional video interviews today!**

[![Get Started](https://img.shields.io/badge/Get%20Started-Now-success?style=for-the-badge&logo=rocket)](http://localhost:8000)
[![Documentation](https://img.shields.io/badge/Read%20Docs-Here-blue?style=for-the-badge&logo=book)](README.md)
[![Support](https://img.shields.io/badge/Get%20Support-Help-orange?style=for-the-badge&logo=question-circle)](mailto:support@hireflix.com)

---

**Made with ❤️ for modern hiring teams**

</div>
