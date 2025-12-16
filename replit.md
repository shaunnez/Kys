# KnowYourStuffNZ Donation Platform

## Overview

This is a full-stack donation platform for KnowYourStuffNZ, a New Zealand-based organization. The application allows users to make donations via cash (credit card) or cryptocurrency. Built with a React frontend and Express backend, it uses PostgreSQL for data persistence and features a modern, accessible UI with shadcn/ui components.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Frontend Architecture
- **Framework**: React 18 with TypeScript
- **Routing**: Wouter (lightweight alternative to React Router)
- **State Management**: TanStack React Query for server state
- **Styling**: Tailwind CSS v4 with CSS variables for theming
- **UI Components**: shadcn/ui (New York style) with Radix UI primitives
- **Build Tool**: Vite with custom plugins for Replit integration

### Backend Architecture
- **Runtime**: Node.js with Express
- **Language**: TypeScript (compiled with tsx for development, esbuild for production)
- **API Pattern**: RESTful endpoints under `/api/` prefix
- **Static Serving**: Express serves the built frontend from `dist/public`

### Data Storage
- **Database**: PostgreSQL (via Neon serverless)
- **ORM**: Drizzle ORM with drizzle-zod for schema validation
- **Schema Location**: `shared/schema.ts` (shared between frontend and backend)
- **Migrations**: Managed via `drizzle-kit push`

### Key Design Patterns
- **Monorepo Structure**: Client, server, and shared code in one repository
- **Path Aliases**: `@/` for client source, `@shared/` for shared code
- **Storage Interface**: `IStorage` interface in `server/storage.ts` allows for different storage implementations
- **Schema Validation**: Zod schemas generated from Drizzle tables for type-safe API validation

### Build Process
- Client: Vite builds to `dist/public`
- Server: esbuild bundles to `dist/index.cjs` with selective dependency bundling
- Production: Single command `npm run build` followed by `npm start`

## External Dependencies

### Database
- **PostgreSQL**: Required via `DATABASE_URL` environment variable
- **Neon Serverless**: `@neondatabase/serverless` for serverless PostgreSQL connections

### UI/Component Libraries
- **Radix UI**: Full suite of accessible primitives (accordion, dialog, dropdown, tabs, etc.)
- **Lucide React**: Icon library
- **Embla Carousel**: Carousel functionality
- **React Day Picker**: Calendar/date picker
- **cmdk**: Command palette component

### Form & Validation
- **React Hook Form**: Form state management with `@hookform/resolvers`
- **Zod**: Schema validation (integrated with Drizzle via `drizzle-zod`)

### Development Tools
- **Replit Plugins**: `@replit/vite-plugin-runtime-error-modal`, `@replit/vite-plugin-cartographer`, `@replit/vite-plugin-dev-banner`
- **Custom Meta Images Plugin**: Updates OpenGraph meta tags for Replit deployments