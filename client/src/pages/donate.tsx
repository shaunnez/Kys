import { useState } from "react";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import {
  Bitcoin,
  CreditCard,
  DollarSign,
  Heart,
  Info,
  Menu,
  Search,
  User,
  Wallet,
} from "lucide-react";
import logoUrl from "@assets/logo.svg";

export default function Donate() {
  return (
    <div className="min-h-screen bg-background font-sans">
      {/* Header */}
      <header className="container mx-auto px-4 py-6 flex items-center justify-between">
        <div className="flex items-center gap-2">
          <img src={logoUrl} alt="KnowYourStuffNZ" className="h-12" />
        </div>

        <nav className="hidden md:flex items-center gap-6 text-sm font-medium tracking-wide">
          <a href="#" className="hover:opacity-70">Pill library</a>
          <a href="#" className="hover:opacity-70">Drug info</a>
          <a href="#" className="hover:opacity-70">Results & Reports</a>
          <a href="#" className="hover:opacity-70">Blog</a>
          <a href="#" className="hover:opacity-70">About</a>
          <a href="#" className="hover:opacity-70">FAQ</a>
          <a href="#" className="border-b-2 border-primary pb-0.5">Donate</a>
          <a href="#" className="hover:opacity-70">Contact</a>
          <a href="#" className="hover:opacity-70">Shop</a>
        </nav>

        <div className="flex items-center gap-3">
          <Button className="rounded-full bg-primary text-primary-foreground hover:bg-primary/90 font-bold px-6 hidden md:inline-flex">
            Find a Clinic!
          </Button>
          <Button variant="ghost" size="icon" className="rounded-full hover:bg-black/5">
            <Search className="h-5 w-5" />
          </Button>
          <Button variant="ghost" size="icon" className="rounded-full hover:bg-black/5">
            <User className="h-5 w-5" />
          </Button>
          <Button variant="ghost" size="icon" className="md:hidden rounded-full hover:bg-black/5">
            <Menu className="h-5 w-5" />
          </Button>
        </div>
      </header>

      {/* Main Content */}
      <main className="container mx-auto px-4 py-12 pb-24">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
          {/* Left Column: Branding & Donation Input */}
          <div className="md:col-span-7 space-y-8">
            {/* Background Pattern (Smiley Faces) - Simplified CSS representation */}
            <div className="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 opacity-10 pointer-events-none">
              <div className="grid grid-cols-12 gap-4 p-4">
                {Array.from({ length: 48 }).map((_, i) => (
                  <div key={i} className="text-4xl">☺</div>
                ))}
              </div>
            </div>

            <div className="mb-8">
              <h1 className="text-4xl md:text-5xl font-bold mb-6 uppercase tracking-wider">Donate</h1>
              <p className="text-lg md:text-xl leading-relaxed max-w-2xl">
                You can donate to us using a credit or debit card, or by bank
                transfer. If you would like to continually support our work
                with a regular donation, the best way to do this is to set up
                an automatic payment through online banking.
              </p>
            </div>

            <div className="bg-transparent">
              <Tabs defaultValue="cash" className="w-full">
                <TabsList className="grid w-full grid-cols-2 mb-8 bg-primary/10 p-1 rounded-full h-auto">
                  <TabsTrigger 
                    value="cash"
                    className="rounded-full py-3 text-base font-bold data-[state=active]:bg-primary data-[state=active]:text-primary-foreground transition-all"
                  >
                    Donate Cash
                  </TabsTrigger>
                  <TabsTrigger 
                    value="crypto"
                    className="rounded-full py-3 text-base font-bold data-[state=active]:bg-primary data-[state=active]:text-primary-foreground transition-all"
                  >
                    Donate Crypto
                  </TabsTrigger>
                </TabsList>

                <TabsContent value="cash" className="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                  <div className="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-lg border border-primary/10">
                    <div className="space-y-6">
                      <div>
                        <label className="block text-sm font-bold mb-2 uppercase tracking-wide text-primary/80">Amount (NZD)</label>
                        <div className="relative">
                          <span className="absolute left-4 top-1/2 -translate-y-1/2 text-xl font-bold text-primary">$</span>
                          <Input 
                            type="number" 
                            placeholder="0" 
                            className="pl-10 h-16 text-2xl font-bold rounded-xl border-2 border-primary/20 focus-visible:ring-primary/30 bg-white"
                          />
                        </div>
                      </div>
                      
                      <div className="grid grid-cols-3 gap-3">
                        {[10, 20, 50].map((amount) => (
                          <Button key={amount} variant="outline" className="h-12 rounded-xl border-2 border-primary/20 hover:bg-primary/5 hover:border-primary text-lg font-semibold">
                            ${amount}
                          </Button>
                        ))}
                      </div>

                      <Button className="w-full h-16 rounded-2xl text-xl font-bold bg-primary text-primary-foreground hover:bg-primary/90 shadow-xl shadow-primary/20 transition-all hover:scale-[1.01]">
                        Donate Now
                      </Button>
                    </div>
                  </div>
                </TabsContent>

                <TabsContent value="crypto" className="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                   <CryptoDonationWidget />
                </TabsContent>
              </Tabs>
            </div>
          </div>

          {/* Right Column: Info Accordion */}
          <div className="md:col-span-5">
            <div className="bg-[#FFFFE0] p-6 rounded-3xl shadow-xl border-2 border-primary/10 sticky top-24">
              <h3 className="text-xl font-bold mb-4 flex items-center gap-2">
                <Info className="w-5 h-5" />
                Ways to Give
              </h3>
              
              <Accordion type="single" collapsible defaultValue="bank" className="w-full space-y-4">
                <AccordionItem value="bank" className="border-2 border-primary/10 rounded-2xl bg-white overflow-hidden data-[state=open]:border-primary/30">
                  <AccordionTrigger className="px-6 py-4 hover:no-underline hover:bg-primary/5 transition-colors font-bold text-lg">
                    <span className="flex items-center gap-3">
                      <div className="bg-primary/10 p-2 rounded-full">
                        <DollarSign className="w-5 h-5 text-primary" />
                      </div>
                      NZ Bank Account Details
                    </span>
                  </AccordionTrigger>
                  <AccordionContent className="px-6 pb-6 pt-2 text-base leading-relaxed text-primary/80 bg-white">
                    <div className="space-y-4">
                      <div className="p-4 bg-primary/5 rounded-xl space-y-3">
                        <div>
                          <span className="block text-xs uppercase font-bold text-primary/50">Account Name</span>
                          <span className="font-mono font-bold text-primary break-words">KNOWYOURSTUFFNZ CHARITABLE TRUST</span>
                        </div>
                        <div>
                          <span className="block text-xs uppercase font-bold text-primary/50">Account Number</span>
                          <span className="font-mono text-lg font-bold text-primary">06-0606-0893413-00</span>
                        </div>
                        <div>
                          <span className="block text-xs uppercase font-bold text-primary/50">SWIFT Code</span>
                          <span className="font-mono font-bold text-primary">ANZBNZ22</span>
                          <span className="text-sm text-primary/60 ml-2">(for international donations)</span>
                        </div>
                      </div>
                      
                      <p className="text-sm italic border-l-4 border-primary/20 pl-4">
                        * If you are making a bank deposit and need a receipt for tax purposes, 
                        please use the contact page to let us know, as these are not automatically 
                        issued and we'll need your contact details to send it.
                      </p>
                    </div>
                  </AccordionContent>
                </AccordionItem>

                <AccordionItem value="card" className="border-2 border-primary/10 rounded-2xl bg-white overflow-hidden data-[state=open]:border-primary/30">
                  <AccordionTrigger className="px-6 py-4 hover:no-underline hover:bg-primary/5 transition-colors font-bold text-lg">
                     <span className="flex items-center gap-3">
                      <div className="bg-primary/10 p-2 rounded-full">
                        <CreditCard className="w-5 h-5 text-primary" />
                      </div>
                      Credit or Debit Card
                    </span>
                  </AccordionTrigger>
                  <AccordionContent className="px-6 pb-6 pt-2 text-base leading-relaxed text-primary/80 bg-white">
                    <p>
                      Secure credit and debit card donations can be made using the "Donate Cash" form 
                      on the left. We use Stripe for secure payment processing. 
                      Your receipt will be emailed to you automatically.
                    </p>
                  </AccordionContent>
                </AccordionItem>

                <AccordionItem value="regular" className="border-2 border-primary/10 rounded-2xl bg-white overflow-hidden data-[state=open]:border-primary/30">
                  <AccordionTrigger className="px-6 py-4 hover:no-underline hover:bg-primary/5 transition-colors font-bold text-lg">
                    <span className="flex items-center gap-3">
                      <div className="bg-primary/10 p-2 rounded-full">
                        <Heart className="w-5 h-5 text-primary" />
                      </div>
                      Regular Giving
                    </span>
                  </AccordionTrigger>
                  <AccordionContent className="px-6 pb-6 pt-2 text-base leading-relaxed text-primary/80 bg-white">
                    <p>
                      Regular donations help us plan ahead. You can set up an Automatic Payment 
                      directly with your bank using the account details above. 
                      Please use your name as a reference so we can identify your donation.
                    </p>
                  </AccordionContent>
                </AccordionItem>
              </Accordion>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}

function CryptoDonationWidget() {
  const [currency, setCurrency] = useState("BTC");
  
  return (
    <Card className="overflow-hidden border-0 shadow-lg rounded-3xl">
      <CardHeader className="bg-white border-b pb-6">
        <CardTitle className="text-center text-2xl font-bold text-[#2A254B]">Make a Donation</CardTitle>
      </CardHeader>
      <CardContent className="p-6 space-y-6 bg-white">
        {/* Coin Selection */}
        <div className="grid grid-cols-3 gap-3">
          <button 
            onClick={() => setCurrency("BTC")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "BTC" ? "border-[#F7931A] bg-[#F7931A]/5 ring-1 ring-[#F7931A]" : "border-slate-200 hover:bg-slate-50"}`}
          >
            <div className="w-6 h-6 rounded-full bg-[#F7931A] text-white flex items-center justify-center text-xs font-bold">₿</div>
            <span className="font-semibold text-slate-700">BTC</span>
          </button>
          <button 
            onClick={() => setCurrency("ETH")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "ETH" ? "border-[#627EEA] bg-[#627EEA]/5 ring-1 ring-[#627EEA]" : "border-slate-200 hover:bg-slate-50"}`}
          >
            <div className="w-6 h-6 rounded-full bg-[#627EEA] text-white flex items-center justify-center text-xs font-bold">Ξ</div>
            <span className="font-semibold text-slate-700">ETH</span>
          </button>
          <button 
            onClick={() => setCurrency("USDC")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "USDC" ? "border-[#2775CA] bg-[#2775CA]/5 ring-1 ring-[#2775CA]" : "border-slate-200 hover:bg-slate-50"}`}
          >
            <div className="w-6 h-6 rounded-full bg-[#2775CA] text-white flex items-center justify-center text-xs font-bold">$</div>
            <span className="font-semibold text-slate-700">USDC</span>
          </button>
        </div>

        {/* Dropdown Selection */}
        <div className="space-y-2">
           <Select defaultValue={currency} onValueChange={setCurrency}>
            <SelectTrigger className="h-14 text-lg rounded-xl border-slate-200">
              <SelectValue placeholder="Select Currency" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="BTC" className="py-3">Bitcoin (BTC)</SelectItem>
              <SelectItem value="ETH" className="py-3">Ethereum (ETH)</SelectItem>
              <SelectItem value="USDC" className="py-3">USD Coin (USDC)</SelectItem>
            </SelectContent>
          </Select>
        </div>

        {/* Amount Input */}
        <div className="flex items-center gap-4">
          <Input 
            className="h-14 text-lg rounded-xl border-slate-200" 
            placeholder="0.0001" 
            defaultValue="0.0001"
          />
          <div className="text-slate-500 font-medium text-lg whitespace-nowrap">
            ≈ $8.64
          </div>
        </div>

        {/* Donate Button */}
        <Button className="w-full h-14 rounded-xl text-lg font-bold bg-[#FCD535] text-black hover:bg-[#FCD535]/90 shadow-sm flex items-center justify-center gap-2">
          Donate
          <Heart className="w-5 h-5 fill-black/20 stroke-black" />
        </Button>
      </CardContent>
    </Card>
  );
}
