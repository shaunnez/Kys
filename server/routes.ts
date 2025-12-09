import type { Express } from "express";
import { createServer, type Server } from "http";
import { storage } from "./storage";
import { insertDonationSchema } from "@shared/schema";

export async function registerRoutes(
  httpServer: Server,
  app: Express
): Promise<Server> {
  // Donation endpoints
  app.post("/api/donations/cash", async (req, res) => {
    try {
      const body = req.body;
      
      // Validate request body
      const validationResult = insertDonationSchema.safeParse({
        donationType: "cash",
        amount: body.amount,
        currency: "NZD",
        firstName: body.firstName,
        lastName: body.lastName,
        email: body.email,
        address1: body.address1,
        address2: body.address2,
        country: body.country,
        state: body.state,
        city: body.city,
        zip: body.zip,
        cardNumber: body.cardNumber,
        cardholderName: body.cardholderName,
        isAnonymous: body.isAnonymous || false,
      });

      if (!validationResult.success) {
        return res.status(400).json({ error: "Invalid donation data" });
      }

      const donation = await storage.createDonation(validationResult.data);
      res.json(donation);
    } catch (error) {
      console.error("Error creating cash donation:", error);
      res.status(500).json({ error: "Failed to create donation" });
    }
  });

  app.post("/api/donations/crypto", async (req, res) => {
    try {
      const body = req.body;
      
      // Validate request body
      const validationResult = insertDonationSchema.safeParse({
        donationType: "crypto",
        amount: body.amount,
        currency: body.currency,
        firstName: body.firstName,
        lastName: body.lastName,
        email: body.email,
        address1: body.address1,
        address2: body.address2,
        country: body.country,
        state: body.state,
        city: body.city,
        zip: body.zip,
        isAnonymous: body.isAnonymous || false,
        walletAddress: body.walletAddress,
        taxReceiptEmail: body.taxReceiptEmail,
      });

      if (!validationResult.success) {
        return res.status(400).json({ error: "Invalid donation data" });
      }

      const donation = await storage.createDonation(validationResult.data);
      res.json(donation);
    } catch (error) {
      console.error("Error creating crypto donation:", error);
      res.status(500).json({ error: "Failed to create donation" });
    }
  });

  app.get("/api/donations", async (req, res) => {
    try {
      const allDonations = await storage.getAllDonations();
      res.json(allDonations);
    } catch (error) {
      console.error("Error fetching donations:", error);
      res.status(500).json({ error: "Failed to fetch donations" });
    }
  });

  app.get("/api/donations/:id", async (req, res) => {
    try {
      const donation = await storage.getDonation(req.params.id);
      if (!donation) {
        return res.status(404).json({ error: "Donation not found" });
      }
      res.json(donation);
    } catch (error) {
      console.error("Error fetching donation:", error);
      res.status(500).json({ error: "Failed to fetch donation" });
    }
  });

  return httpServer;
}
