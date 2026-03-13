# Dakar-Terminal - Port Management System

A Spring Boot 3.2 application for the Dakar Terminal port management system. This is a complete port of the Laravel application with all domain features including billing workflows, yard management, ticketing, EDI, and more.

## Technology Stack

- **Java 17**
- **Spring Boot 3.2.3**
- **Spring Security** with JWT authentication
- **Spring Data JPA** with Hibernate
- **Spring WebSocket** (STOMP over SockJS)
- **Spring Mail** (Gmail SMTP)
- **MySQL 8+**
- **Flyway** database migrations
- **Apache POI** for Excel generation/import
- **OpenPDF** for PDF generation
- **AWS S3 SDK** for file storage (also supports Backblaze B2)
- **Lombok**
- **jjwt 0.12.5**

## Project Structure

```
src/main/java/sn/dakarterminal/dt/
├── DakarTerminalApplication.java       # Main entry point
├── controller/                         # REST controllers (25 controllers)
├── dto/                                # Data Transfer Objects
├── entity/                             # JPA entities
├── enums/                              # Domain enumerations
├── event/                              # Spring application events
├── exception/                          # Exception handling
├── job/                                # Scheduled jobs (@Scheduled)
├── listener/                           # Event listeners
├── repository/                         # JPA repositories
├── security/                           # JWT security configuration
├── service/                            # Business logic services
└── websocket/                          # WebSocket configuration and handlers
```

## Features

### Authentication & Security
- JWT-based stateless authentication
- Role-based access control (RBAC) with 10 roles
- Two-factor authentication support
- BCrypt password encoding (strength 12)
- CORS configuration

### Billing Workflow (Facturation)
- BL (Bill of Lading) attachment requests (Rattachement BL)
- Dossier lifecycle: EN_ATTENTE_VALIDATION → VALIDE → EN_ATTENTE_PROFORMA → EN_ATTENTE_FACTURE → EN_ATTENTE_BAD → CLOTURE
- Proforma document upload and validation
- Invoice (Facture) upload and validation
- Delivery order (Bon/BAD) upload and validation
- Email notifications at each step
- Bulk Excel import with staging table pattern
- PDF generation for proformas and invoices
- Excel export for reports

### Yard Management
- Container tracking (position, state, type)
- Bulk Excel import with staging/consolidation pattern
- Excel export

### Queue / Ticketing System
- Service-based ticket queue
- Agent and guichet (counter) assignment
- Real-time updates via WebSocket (STOMP)
- Ticket lifecycle: EN_ATTENTE → EN_COURS → TERMINE/ABSENT
- Processing time tracking

### Operations
- Ordre d'Approche (vessel approach orders) management
- Planification (scheduling) views
- CSV/Excel import with background processing

### IT Equipment (Informatique)
- Machine inventory (ORDINATEUR, ECRAN, CLAVIER, SOURIS, TELEPHONE_FIXE, TELEPHONE_MOBILE, STATION)
- Serial number tracking
- Assignment to users and services
- Excel export

### EDI (Electronic Data Interchange)
- EDIFACT/XML file ingestion
- Message parsing and processing
- Error tracking

### IPAKI Platform
- Third-party (Tiers) management
- NINEA and RC tracking

### Customs (Douane)
- Read-only access to facturation data filtered for customs use

### Dematerialization (IES/Demat)
- Temporary employee badge requests
- Document upload
- Validation workflow

### GFA (Financial Management)
- User account management
- Balance (solde) tracking
- Credit limit management

### Reports & Audits
- Facturation period reports
- Yard reports
- Structured audit logging

## Configuration

### Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_HOST` | localhost | MySQL host |
| `DB_PORT` | 3306 | MySQL port |
| `DB_NAME` | dakar_terminal | Database name |
| `DB_USERNAME` | root | Database username |
| `DB_PASSWORD` | (empty) | Database password |
| `MAIL_HOST` | smtp.gmail.com | SMTP host |
| `MAIL_PORT` | 587 | SMTP port |
| `MAIL_USERNAME` | (empty) | SMTP username |
| `MAIL_PASSWORD` | (empty) | SMTP password |
| `JWT_SECRET` | (see config) | JWT signing secret (min 256 bits) |
| `JWT_EXPIRATION` | 86400000 | JWT expiry in ms (24h) |
| `STORAGE_TYPE` | local | `local` or `s3` |
| `LOCAL_STORAGE_PATH` | ./uploads | Local file storage path |
| `S3_ENDPOINT` | (empty) | S3/B2 endpoint URL |
| `S3_BUCKET` | dakar-terminal | S3/B2 bucket name |
| `S3_REGION` | us-east-1 | S3/B2 region |
| `S3_ACCESS_KEY` | (empty) | S3/B2 access key |
| `S3_SECRET_KEY` | (empty) | S3/B2 secret key |
| `S3_PUBLIC_URL` | (empty) | Public URL for files |
| `SERVER_PORT` | 8080 | HTTP port |
| `APP_URL` | http://localhost:8080 | Application base URL |
| `FRONTEND_URL` | http://localhost:3000 | Frontend URL (CORS) |

## Quick Start

### Prerequisites
- Java 17+
- Maven 3.8+
- MySQL 8+

### Setup

1. **Create the database:**
   ```sql
   CREATE DATABASE dakar_terminal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Configure environment (dev):**
   Edit `src/main/resources/application-dev.yml` with your database credentials.

3. **Build the project:**
   ```bash
   mvn clean package -DskipTests
   ```

4. **Run the application:**
   ```bash
   java -jar target/dt-1.0.0.jar --spring.profiles.active=dev
   ```
   Or with Maven:
   ```bash
   mvn spring-boot:run -Dspring-boot.run.profiles=dev
   ```

5. **Flyway will automatically run all migrations** and create the database schema.

### Default Admin Credentials
After startup, a default admin account is created:
- **Email:** `admin@dakarterminal.sn`
- **Password:** `Admin@2024!`

**Change the password immediately after first login.**

## API Endpoints

### Authentication
| Method | Path | Description |
|--------|------|-------------|
| POST | `/api/auth/login` | Login with email/password |
| POST | `/api/auth/refresh` | Refresh JWT token |
| POST | `/api/auth/logout` | Logout |
| GET | `/api/auth/me` | Get current user |

### Users & Roles
| Method | Path | Access |
|--------|------|--------|
| GET | `/api/users` | ADMIN, SUPER_U |
| POST | `/api/users` | ADMIN, SUPER_U |
| PUT | `/api/users/{id}` | ADMIN, SUPER_U |
| DELETE | `/api/users/{id}` | ADMIN |
| GET | `/api/roles` | All authenticated |

### Billing
| Method | Path | Description |
|--------|------|-------------|
| GET/POST | `/api/rattachements` | BL attachments |
| PATCH | `/api/rattachements/{id}/valider` | Validate attachment |
| GET/POST | `/api/dossiers` | Billing dossiers |
| POST | `/api/dossiers/{id}/proforma/upload` | Upload proforma |
| POST | `/api/dossiers/{id}/facture/upload` | Upload invoice |
| POST | `/api/dossiers/{id}/bon/upload` | Upload delivery order |
| GET/POST | `/api/facturation` | Facturation records |
| POST | `/api/facturation/import` | Bulk Excel import |

### Operations
| Method | Path | Description |
|--------|------|-------------|
| GET/POST | `/api/yard` | Yard management |
| POST | `/api/yard/import` | Bulk yard import |
| GET/POST | `/api/ordre-approches` | Approach orders |
| GET | `/api/planification/planning` | Planning view |

### Queue System
| Method | Path | Description |
|--------|------|-------------|
| POST | `/api/tickets` | Create ticket |
| POST | `/api/tickets/call-next` | Call next ticket |
| PATCH | `/api/tickets/{id}/close` | Close ticket |
| GET | `/api/tickets/waiting` | All waiting tickets |

### WebSocket Topics
| Topic | Description |
|-------|-------------|
| `/topic/tickets/created` | New ticket created |
| `/topic/tickets/called` | Ticket called to counter |
| `/topic/tickets/closed` | Ticket closed |
| `/topic/service/{serviceId}/queue` | Service queue update |
| `/topic/display/{serviceId}` | Display board update |

### Reports
| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/rapports/facturation/excel` | Export facturation report |
| GET | `/api/rapports/yard/excel` | Export yard report |

## Roles

| Role | Description |
|------|-------------|
| `ADMIN` | Full system access |
| `SUPER_U` | Super user, near-full access |
| `FACTURATION` | Billing team |
| `CLIENT_FACTURATION` | Client billing access |
| `OPERATIONS` | Port operations |
| `PLANIFICATION` | Scheduling and planning |
| `INFORMATIQUE` | IT equipment management |
| `DOUANE` | Customs access |
| `GFA` | Financial management |
| `IPAKI` | IPAKI platform integration |

## Database Migrations (Flyway)

| Version | Description |
|---------|-------------|
| V1 | Create roles table |
| V2 | Create users table |
| V3 | Create rattachement_bls table |
| V4 | Create dossier_facturations table |
| V5 | Create dossier document tables (proformas, factures, bons) |
| V6 | Create facturations and staging tables |
| V7 | Create machines table |
| V8 | Create ordre_approches tables |
| V9 | Create yards tables |
| V10 | Create tickets, services, agents, guichets tables |
| V11 | Create tiers_ipaki table |
| V12 | Create edi_records table |
| V13 | Create user_accounts and scan_tokens tables |
| V14 | Create employee_temporaire_demandes table |
| V15 | Create rapport tables |
| V16 | Insert initial roles and admin user |

## Production Deployment

### Using application-prod.yml
```bash
java -jar target/dt-1.0.0.jar \
  --spring.profiles.active=prod \
  --DB_HOST=your-db-host \
  --DB_NAME=dakar_terminal \
  --DB_USERNAME=dt_user \
  --DB_PASSWORD=your-secure-password \
  --JWT_SECRET=your-256-bit-secret \
  --STORAGE_TYPE=s3 \
  --S3_ENDPOINT=https://s3.us-east-005.backblazeb2.com \
  --S3_BUCKET=dakar-terminal \
  --S3_ACCESS_KEY=your-key \
  --S3_SECRET_KEY=your-secret \
  --MAIL_HOST=smtp.gmail.com \
  --MAIL_USERNAME=noreply@dakarterminal.sn \
  --MAIL_PASSWORD=your-app-password
```

### Docker

```dockerfile
FROM eclipse-temurin:17-jre-alpine
WORKDIR /app
COPY target/dt-1.0.0.jar app.jar
EXPOSE 8080
ENTRYPOINT ["java", "-jar", "app.jar"]
```

## Health Check

```
GET /actuator/health
```

## License

Proprietary - Dakar Terminal © 2024
