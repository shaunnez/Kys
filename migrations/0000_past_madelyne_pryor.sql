CREATE TABLE "donations" (
	"id" varchar PRIMARY KEY DEFAULT gen_random_uuid() NOT NULL,
	"donation_type" text NOT NULL,
	"amount" numeric(18, 8) NOT NULL,
	"currency" text NOT NULL,
	"first_name" text,
	"last_name" text,
	"email" text,
	"address1" text,
	"address2" text,
	"country" text,
	"state" text,
	"city" text,
	"zip" text,
	"card_number" text,
	"cardholder_name" text,
	"is_anonymous" boolean DEFAULT false,
	"wallet_address" text,
	"tax_receipt_email" text,
	"created_at" timestamp DEFAULT now()
);
--> statement-breakpoint
CREATE TABLE "users" (
	"id" varchar PRIMARY KEY DEFAULT gen_random_uuid() NOT NULL,
	"username" text NOT NULL,
	"password" text NOT NULL,
	CONSTRAINT "users_username_unique" UNIQUE("username")
);
