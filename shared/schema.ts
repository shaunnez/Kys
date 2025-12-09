import { sql } from "drizzle-orm";
import { pgTable, text, varchar, decimal, boolean, timestamp } from "drizzle-orm/pg-core";
import { createInsertSchema } from "drizzle-zod";
import { z } from "zod";

export const users = pgTable("users", {
  id: varchar("id").primaryKey().default(sql`gen_random_uuid()`),
  username: text("username").notNull().unique(),
  password: text("password").notNull(),
});

export const donations = pgTable("donations", {
  id: varchar("id").primaryKey().default(sql`gen_random_uuid()`),
  donationType: text("donation_type").notNull(), // "cash" or "crypto"
  amount: decimal("amount", { precision: 18, scale: 8 }).notNull(),
  currency: text("currency").notNull(), // "NZD", "BTC", "ETH", "USDT", "USDC"
  firstName: text("first_name"),
  lastName: text("last_name"),
  email: text("email"),
  address1: text("address1"),
  address2: text("address2"),
  country: text("country"),
  state: text("state"),
  city: text("city"),
  zip: text("zip"),
  cardNumber: text("card_number"),
  cardholderName: text("cardholder_name"),
  isAnonymous: boolean("is_anonymous").default(false),
  walletAddress: text("wallet_address"),
  taxReceiptEmail: text("tax_receipt_email"),
  createdAt: timestamp("created_at").default(sql`now()`),
});

export const insertUserSchema = createInsertSchema(users).pick({
  username: true,
  password: true,
});

export const insertDonationSchema = createInsertSchema(donations).omit({
  id: true,
  createdAt: true,
});

export type InsertUser = z.infer<typeof insertUserSchema>;
export type User = typeof users.$inferSelect;
export type InsertDonation = z.infer<typeof insertDonationSchema>;
export type Donation = typeof donations.$inferSelect;
