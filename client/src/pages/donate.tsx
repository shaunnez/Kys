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
import { Checkbox } from "@/components/ui/checkbox";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
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
  ArrowLeft,
  Lock,
  X,
} from "lucide-react";
import logoUrl from "@assets/logo.svg";

export default function Donate() {
  const [cashDonationStep, setCashDonationStep] = useState<"initial" | "payment">("initial");
  const [cashAmount, setCashAmount] = useState("100");

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
                            min="0"
                            value={cashAmount}
                            onChange={(e) => {
                              const val = e.target.value;
                              if (val === "" || parseFloat(val) >= 0) {
                                setCashAmount(val);
                              }
                            }}
                            className="pl-10 h-16 text-2xl font-bold rounded-xl border-2 border-primary/20 focus-visible:ring-primary/30 bg-white"
                            data-testid="input-cash-amount"
                          />
                        </div>
                      </div>
                      
                      <div className="grid grid-cols-3 gap-3">
                        {[10, 20, 50].map((amount) => (
                          <Button 
                            key={amount} 
                            variant="outline" 
                            onClick={() => setCashAmount(amount.toString())}
                            className="h-12 rounded-xl border-2 border-primary/20 hover:bg-primary/5 hover:border-primary text-lg font-semibold"
                            data-testid={`button-amount-${amount}`}
                          >
                            ${amount}
                          </Button>
                        ))}
                      </div>

                      <Button 
                        onClick={() => setCashDonationStep("payment")}
                        disabled={!cashAmount || parseFloat(cashAmount) <= 0}
                        className="w-full h-16 rounded-2xl text-xl font-bold bg-primary text-primary-foreground hover:bg-primary/90 shadow-xl shadow-primary/20 transition-all hover:scale-[1.01] disabled:opacity-50 disabled:cursor-not-allowed"
                        data-testid="button-donate-cash"
                      >
                        Donate Now
                      </Button>
                    </div>
                  </div>

                  <Dialog open={cashDonationStep === "payment"} onOpenChange={(open) => !open && setCashDonationStep("initial")}>
                    <DialogContent className="max-h-[90vh] overflow-y-auto max-w-2xl bg-white">
                      <DialogHeader className="sticky top-0 bg-white z-10 pb-4">
                        <DialogTitle className="text-2xl font-bold">Payment Details</DialogTitle>
                      </DialogHeader>
                      <CashPaymentForm 
                        amount={cashAmount}
                        onBack={() => setCashDonationStep("initial")}
                      />
                    </DialogContent>
                  </Dialog>
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

function CashPaymentForm({ amount, onBack }: { amount: string; onBack: () => void }) {
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    email: "",
    cardNumber: "",
    cvc: "",
    cardholderName: "",
    expiration: "",
    country: "New Zealand",
    address1: "",
    address2: "",
    city: "",
    region: "Wellington",
    zip: "",
  });
  const [errors, setErrors] = useState<Record<string, string>>({});

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    // Clear error for this field when user starts typing
    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ""
      }));
    }
  };

  const validateForm = (): boolean => {
    const newErrors: Record<string, string> = {};
    
    if (!formData.firstName.trim()) newErrors.firstName = "Required";
    if (!formData.lastName.trim()) newErrors.lastName = "Required";
    if (!formData.email.trim()) newErrors.email = "Required";
    if (!formData.email.includes("@")) newErrors.email = "Invalid email";
    if (!formData.cardNumber.trim()) newErrors.cardNumber = "Required";
    if (!formData.cvc.trim()) newErrors.cvc = "Required";
    if (!formData.cardholderName.trim()) newErrors.cardholderName = "Required";
    if (!formData.expiration.trim()) newErrors.expiration = "Required";
    if (!formData.address1.trim()) newErrors.address1 = "Required";
    if (!formData.city.trim()) newErrors.city = "Required";
    if (!formData.zip.trim()) newErrors.zip = "Required";

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  return (
    <div className="space-y-6">
        {/* Personal Information */}
        <div className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                First Name <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="firstName"
                value={formData.firstName}
                onChange={handleChange}
                placeholder="First Name" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.firstName ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-payment-firstName"
              />
              {errors.firstName && <p className="text-red-500 text-xs mt-1">{errors.firstName}</p>}
            </div>
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Last Name <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="lastName"
                value={formData.lastName}
                onChange={handleChange}
                placeholder="Last Name" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.lastName ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-payment-lastName"
              />
              {errors.lastName && <p className="text-red-500 text-xs mt-1">{errors.lastName}</p>}
            </div>
          </div>

          <div>
            <label className="block text-sm font-semibold text-slate-700 mb-2">
              Email Address <span className="text-red-500">*</span>
              <Info className="inline w-4 h-4 ml-1 text-slate-400" />
            </label>
            <Input 
              name="email"
              type="email"
              value={formData.email}
              onChange={handleChange}
              placeholder="Email Address" 
              className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.email ? "border-red-500" : "border-slate-300"}`}
              data-testid="input-payment-email"
            />
            {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
          </div>
        </div>

        {/* Credit Card Information */}
        <div className="space-y-4 pt-4 border-t border-slate-200">
          <h3 className="font-bold text-slate-900">Credit Card Info</h3>
          
          <div className="flex items-center gap-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <Lock className="w-4 h-4 text-blue-600" />
            <span className="text-sm text-blue-700">This is a secure SSL encrypted payment.</span>
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Card Number <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="cardNumber"
                value={formData.cardNumber}
                onChange={handleChange}
                placeholder="Card Number" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.cardNumber ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-card-number"
              />
              {errors.cardNumber && <p className="text-red-500 text-xs mt-1">{errors.cardNumber}</p>}
            </div>
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                CVC <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="cvc"
                value={formData.cvc}
                onChange={handleChange}
                placeholder="CVC" 
                maxLength={4}
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.cvc ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-cvc"
              />
              {errors.cvc && <p className="text-red-500 text-xs mt-1">{errors.cvc}</p>}
            </div>
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Cardholder Name <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="cardholderName"
                value={formData.cardholderName}
                onChange={handleChange}
                placeholder="Cardholder Name" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.cardholderName ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-cardholder-name"
              />
              {errors.cardholderName && <p className="text-red-500 text-xs mt-1">{errors.cardholderName}</p>}
            </div>
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Expiration <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="expiration"
                value={formData.expiration}
                onChange={handleChange}
                placeholder="MM / YY" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.expiration ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-expiration"
              />
              {errors.expiration && <p className="text-red-500 text-xs mt-1">{errors.expiration}</p>}
            </div>
          </div>
        </div>

        {/* Billing Details */}
        <div className="space-y-4 pt-4 border-t border-slate-200">
          <h3 className="font-bold text-slate-900">Billing Details</h3>

          <div>
            <label className="block text-sm font-semibold text-slate-700 mb-2">
              Country <span className="text-red-500">*</span>
              <Info className="inline w-4 h-4 ml-1 text-slate-400" />
            </label>
            <select 
              name="country"
              value={formData.country}
              onChange={handleChange}
              className="w-full h-10 rounded-lg border border-slate-300 px-3 text-slate-600 font-medium"
              data-testid="select-country"
            >
              <option>New Zealand</option>
              <option>Australia</option>
              <option>United States</option>
              <option>United Kingdom</option>
              <option>Canada</option>
            </select>
          </div>

          <div>
            <label className="block text-sm font-semibold text-slate-700 mb-2">
              Address 1 <span className="text-red-500">*</span>
              <Info className="inline w-4 h-4 ml-1 text-slate-400" />
            </label>
            <Input 
              name="address1"
              value={formData.address1}
              onChange={handleChange}
              placeholder="Address line 1" 
              className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.address1 ? "border-red-500" : "border-slate-300"}`}
              data-testid="input-address1-payment"
            />
            {errors.address1 && <p className="text-red-500 text-xs mt-1">{errors.address1}</p>}
          </div>

          <div>
            <label className="block text-sm font-semibold text-slate-700 mb-2">
              Address 2 <Info className="inline w-4 h-4 ml-1 text-slate-400" />
            </label>
            <Input 
              name="address2"
              value={formData.address2}
              onChange={handleChange}
              placeholder="Address line 2" 
              className="h-10 rounded-lg border-slate-300 placeholder-slate-300 text-slate-600"
              data-testid="input-address2-payment"
            />
          </div>

          <div>
            <label className="block text-sm font-semibold text-slate-700 mb-2">
              City <span className="text-red-500">*</span>
              <Info className="inline w-4 h-4 ml-1 text-slate-400" />
            </label>
            <Input 
              name="city"
              value={formData.city}
              onChange={handleChange}
              placeholder="City" 
              className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.city ? "border-red-500" : "border-slate-300"}`}
              data-testid="input-city-payment"
            />
            {errors.city && <p className="text-red-500 text-xs mt-1">{errors.city}</p>}
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Region <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <select 
                name="region"
                value={formData.region}
                onChange={handleChange}
                className="w-full h-10 rounded-lg border border-slate-300 px-3 text-slate-600 font-medium"
                data-testid="select-region"
              >
                <option>Wellington</option>
                <option>Auckland</option>
                <option>Christchurch</option>
                <option>Dunedin</option>
              </select>
            </div>
            <div>
              <label className="block text-sm font-semibold text-slate-700 mb-2">
                Zip / Postal Code <span className="text-red-500">*</span>
                <Info className="inline w-4 h-4 ml-1 text-slate-400" />
              </label>
              <Input 
                name="zip"
                value={formData.zip}
                onChange={handleChange}
                placeholder="Zip / Postal Code" 
                className={`h-10 rounded-lg border-2 placeholder-slate-300 text-slate-600 ${errors.zip ? "border-red-500" : "border-slate-300"}`}
                data-testid="input-zip-payment"
              />
              {errors.zip && <p className="text-red-500 text-xs mt-1">{errors.zip}</p>}
            </div>
          </div>
        </div>

      {/* Donate Button */}
      <Button 
        onClick={() => {
          if (validateForm()) {
            console.log("Form submitted:", formData);
          }
        }}
        className="w-full h-12 rounded-lg text-base font-bold bg-primary text-primary-foreground hover:bg-primary/90 mt-6 disabled:opacity-50"
        data-testid="button-complete-donation"
      >
        Please Donate Now - ${amount || "0"}
      </Button>
    </div>
  );
}

function CryptoDonationWidget() {
  // Exchange rates: 1 unit of crypto = X NZD
  const exchangeRates: Record<string, number> = {
    BTC: 130000,
    ETH: 4500,
    USDT: 1.65,
    USDC: 1.65,
  };

  const [currency, setCurrency] = useState("BTC");
  const [step, setStep] = useState("donation"); // donation, personalInfo, taxReceipt, walletAddress
  const [isAnonymous, setIsAnonymous] = useState(false);
  const [nzdAmount, setNzdAmount] = useState("100");
  const [cryptoErrors, setCryptoErrors] = useState<Record<string, string>>({});
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    email: "",
    address1: "",
    address2: "",
    country: "",
    state: "",
    city: "",
    zip: "",
  });
  const [taxEmail, setTaxEmail] = useState("");

  const handleCurrencyChange = (newCurrency: string) => {
    setCurrency(newCurrency);
  };

  const cryptoAmount = nzdAmount ? (parseFloat(nzdAmount) / exchangeRates[currency]).toFixed(8) : "0";

  const validateCryptoPersonalInfo = (): boolean => {
    const newErrors: Record<string, string> = {};
    
    if (!isAnonymous) {
      if (!formData.firstName.trim()) newErrors.firstName = "Required";
      if (!formData.lastName.trim()) newErrors.lastName = "Required";
      if (!formData.email.trim()) newErrors.email = "Required";
      if (!formData.email.includes("@")) newErrors.email = "Invalid email";
      if (!formData.address1.trim()) newErrors.address1 = "Required";
      if (!formData.country.trim()) newErrors.country = "Required";
      if (!formData.state.trim()) newErrors.state = "Required";
      if (!formData.city.trim()) newErrors.city = "Required";
      if (!formData.zip.trim()) newErrors.zip = "Required";
    }

    setCryptoErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleCopyAddress = () => {
    navigator.clipboard.writeText("bc1qllutxxxkeyeh0d...fj3m9twh35vydd67e0");
  };

  if (step === "personalInfo") {
    return (
      <Card className="overflow-hidden border-0 shadow-lg rounded-3xl">
        <CardHeader className="bg-white border-b pb-6 px-6 py-6">
          <div className="flex items-center gap-4 mb-2">
            <button 
              onClick={() => setStep("donation")}
              className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
              data-testid="button-back"
            >
              <ArrowLeft className="h-5 w-5 text-slate-700" />
            </button>
            <CardTitle className="text-2xl font-bold text-slate-900">Personal Info</CardTitle>
          </div>
        </CardHeader>
        <CardContent className="p-6 bg-white space-y-5">
          {/* Anonymous Checkbox */}
          <div className="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <Checkbox 
              id="anonymous"
              checked={isAnonymous}
              onCheckedChange={(checked) => setIsAnonymous(checked as boolean)}
              className="w-5 h-5"
              data-testid="checkbox-anonymous"
            />
            <label 
              htmlFor="anonymous" 
              className="text-base font-medium text-slate-700 cursor-pointer flex-1"
            >
              Make donation anonymous
            </label>
          </div>

          {!isAnonymous && (
            <div className="space-y-4">
              {/* First Name and Last Name */}
              <div className="grid grid-cols-2 gap-3">
                <div>
                  <Input 
                    name="firstName"
                    value={formData.firstName}
                    onChange={handleInputChange}
                    placeholder="First name" 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.firstName ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-firstName"
                  />
                  {cryptoErrors.firstName && <p className="text-red-500 text-xs mt-1">{cryptoErrors.firstName}</p>}
                </div>
                <div>
                  <Input 
                    name="lastName"
                    value={formData.lastName}
                    onChange={handleInputChange}
                    placeholder="Last name" 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.lastName ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-lastName"
                  />
                  {cryptoErrors.lastName && <p className="text-red-500 text-xs mt-1">{cryptoErrors.lastName}</p>}
                </div>
              </div>

              {/* Email */}
              <div>
                <Input 
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                  placeholder="Email" 
                  type="email"
                  className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.email ? "border-red-500" : "border-slate-200"}`}
                  data-testid="input-email"
                />
                {cryptoErrors.email && <p className="text-red-500 text-xs mt-1">{cryptoErrors.email}</p>}
              </div>

              {/* Address 1 */}
              <div>
                <Input 
                  name="address1"
                  value={formData.address1}
                  onChange={handleInputChange}
                  placeholder="Address 1" 
                  className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.address1 ? "border-red-500" : "border-slate-200"}`}
                  data-testid="input-address1"
                />
                {cryptoErrors.address1 && <p className="text-red-500 text-xs mt-1">{cryptoErrors.address1}</p>}
              </div>

              {/* Address 2 */}
              <Input 
                name="address2"
                value={formData.address2}
                onChange={handleInputChange}
                placeholder="Address 2" 
                className="h-12 rounded-xl border-slate-200 text-slate-400 placeholder-slate-400"
                data-testid="input-address2"
              />

              {/* Country and State */}
              <div className="grid grid-cols-2 gap-3">
                <div>
                  <Input 
                    name="country"
                    value={formData.country}
                    onChange={handleInputChange}
                    placeholder="Country" 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.country ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-country"
                  />
                  {cryptoErrors.country && <p className="text-red-500 text-xs mt-1">{cryptoErrors.country}</p>}
                </div>
                <div>
                  <Input 
                    name="state"
                    value={formData.state}
                    onChange={handleInputChange}
                    placeholder="State/Provinc..." 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.state ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-state"
                  />
                  {cryptoErrors.state && <p className="text-red-500 text-xs mt-1">{cryptoErrors.state}</p>}
                </div>
              </div>

              {/* City and ZIP */}
              <div className="grid grid-cols-2 gap-3">
                <div>
                  <Input 
                    name="city"
                    value={formData.city}
                    onChange={handleInputChange}
                    placeholder="City" 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.city ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-city"
                  />
                  {cryptoErrors.city && <p className="text-red-500 text-xs mt-1">{cryptoErrors.city}</p>}
                </div>
                <div>
                  <Input 
                    name="zip"
                    value={formData.zip}
                    onChange={handleInputChange}
                    placeholder="ZIP/Postal Code" 
                    className={`h-12 rounded-xl border-2 text-slate-600 placeholder-slate-400 ${cryptoErrors.zip ? "border-red-500" : "border-slate-200"}`}
                    data-testid="input-zip"
                  />
                  {cryptoErrors.zip && <p className="text-red-500 text-xs mt-1">{cryptoErrors.zip}</p>}
                </div>
              </div>
            </div>
          )}

          {/* Next Button */}
          <Button 
            onClick={() => {
              if (validateCryptoPersonalInfo()) {
                setStep("taxReceipt");
              }
            }}
            className="w-full h-14 rounded-xl text-lg font-bold bg-[#FCD535] text-black hover:bg-[#FCD535]/90 shadow-sm"
            data-testid="button-next"
          >
            Next
          </Button>
        </CardContent>
      </Card>
    );
  }

  if (step === "taxReceipt") {
    return (
      <Card className="overflow-hidden border-0 shadow-lg rounded-3xl">
        <CardHeader className="bg-white border-b pb-6 px-6 py-6">
          <div className="flex items-center gap-4 mb-2">
            <button 
              onClick={() => setStep("personalInfo")}
              className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
              data-testid="button-back-tax"
            >
              <ArrowLeft className="h-5 w-5 text-slate-700" />
            </button>
            <CardTitle className="text-2xl font-bold text-slate-900">Want A Tax Receipt?</CardTitle>
          </div>
        </CardHeader>
        <CardContent className="p-6 bg-white space-y-6">
          <p className="text-base text-slate-700 leading-relaxed">
            If you would like to receive a tax receipt while remaining anonymous, enter your email below. This email will only be used for the purpose of issuing your tax receipt.
          </p>

          <Input 
            value={taxEmail}
            onChange={(e) => setTaxEmail(e.target.value)}
            placeholder="Enter email for tax receipt" 
            type="email"
            className="h-12 rounded-xl border-slate-200 text-slate-600 placeholder-slate-400"
            data-testid="input-tax-email"
          />

          <div className="flex gap-3">
            <Button 
              onClick={() => setStep("walletAddress")}
              variant="outline"
              className="flex-1 h-12 rounded-xl text-base font-bold border-2 border-slate-300 text-slate-700 hover:bg-slate-50"
              data-testid="button-skip"
            >
              Skip
            </Button>
            <Button 
              onClick={() => setStep("walletAddress")}
              className="flex-1 h-12 rounded-xl text-base font-bold bg-[#FCD535] text-black hover:bg-[#FCD535]/90 shadow-sm"
              data-testid="button-get-receipt"
            >
              Get receipt
            </Button>
          </div>
        </CardContent>
      </Card>
    );
  }

  if (step === "walletAddress") {
    const btcAmount = "0.00010000000000000000002 BTC";
    const walletAddress = "bc1qllutxxxkeyeh0d...fj3m9twh35vydd67e0";
    
    return (
      <Card className="overflow-hidden border-0 shadow-lg rounded-3xl">
        <CardHeader className="bg-white border-b pb-6 px-6 py-6">
          <div className="flex items-center gap-4">
            <button 
              onClick={() => setStep("taxReceipt")}
              className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
              data-testid="button-back-wallet"
            >
              <ArrowLeft className="h-5 w-5 text-slate-700" />
            </button>
            <div>
              <CardTitle className="text-2xl font-bold text-slate-900 flex items-center gap-2">
                {btcAmount}
                <Info className="h-4 w-4 text-slate-500" />
              </CardTitle>
            </div>
          </div>
        </CardHeader>
        <CardContent className="p-6 bg-white space-y-6">
          <p className="text-base text-slate-700 text-center">
            Use the address below to make a donation from your wallet.
          </p>

          {/* QR Code Placeholder */}
          <div className="flex justify-center">
            <div className="w-48 h-48 bg-slate-100 rounded-2xl border-2 border-slate-200 flex items-center justify-center">
              <div className="text-center">
                <div className="text-4xl mb-2">📱</div>
                <span className="text-sm text-slate-500">QR Code</span>
              </div>
            </div>
          </div>

          {/* Wallet Address */}
          <div className="p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div className="flex items-center gap-2">
              <input 
                type="text" 
                value={walletAddress}
                readOnly
                className="flex-1 bg-transparent font-mono text-sm text-slate-700 outline-none"
                data-testid="input-wallet-address"
              />
              <button 
                onClick={handleCopyAddress}
                className="p-2 hover:bg-slate-200 rounded-lg transition-colors"
                data-testid="button-copy"
              >
                <svg className="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
              </button>
            </div>
          </div>

          {/* Warning Text */}
          <div className="p-4 bg-orange-50 rounded-xl border border-orange-200">
            <p className="text-sm text-orange-700 leading-relaxed">
              <span className="font-semibold">Send only BTC to this address using the Bitcoin blockchain.</span> Sending other unsupported tokens or NFTs to this address may result in the loss of your donation. The address will expire after 180 days of unused.
            </p>
          </div>

          {/* Start Over Button */}
          <Button 
            onClick={() => {
              setStep("donation");
              setCurrency("BTC");
              setFormData({ firstName: "", lastName: "", email: "", address1: "", address2: "", country: "", state: "", city: "", zip: "" });
              setTaxEmail("");
              setIsAnonymous(false);
            }}
            className="w-full h-12 rounded-xl text-base font-bold bg-[#FCD535] text-black hover:bg-[#FCD535]/90 shadow-sm"
            data-testid="button-start-over"
          >
            Start Over
          </Button>
        </CardContent>
      </Card>
    );
  }

  return (
    <Card className="overflow-hidden border-0 shadow-lg rounded-3xl">
      <CardHeader className="bg-white border-b pb-6">
        <CardTitle className="text-center text-2xl font-bold text-[#2A254B]">Make a Donation</CardTitle>
      </CardHeader>
      <CardContent className="p-6 space-y-6 bg-white">
        {/* Coin Selection */}
        <div className="grid grid-cols-3 gap-3">
          <button 
            onClick={() => handleCurrencyChange("BTC")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "BTC" ? "border-[#F7931A] bg-[#F7931A]/5 ring-1 ring-[#F7931A]" : "border-slate-200 hover:bg-slate-50"}`}
            data-testid="button-btc"
          >
            <div className="w-6 h-6 rounded-full bg-[#F7931A] text-white flex items-center justify-center text-xs font-bold">₿</div>
            <span className="font-semibold text-slate-700">BTC</span>
          </button>
          <button 
            onClick={() => handleCurrencyChange("ETH")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "ETH" ? "border-[#627EEA] bg-[#627EEA]/5 ring-1 ring-[#627EEA]" : "border-slate-200 hover:bg-slate-50"}`}
            data-testid="button-eth"
          >
            <div className="w-6 h-6 rounded-full bg-[#627EEA] text-white flex items-center justify-center text-xs font-bold">Ξ</div>
            <span className="font-semibold text-slate-700">ETH</span>
          </button>
          <button 
            onClick={() => handleCurrencyChange("USDC")}
            className={`flex items-center justify-center gap-2 py-3 px-2 rounded-xl border transition-all ${currency === "USDC" ? "border-[#2775CA] bg-[#2775CA]/5 ring-1 ring-[#2775CA]" : "border-slate-200 hover:bg-slate-50"}`}
            data-testid="button-usdc"
          >
            <div className="w-6 h-6 rounded-full bg-[#2775CA] text-white flex items-center justify-center text-xs font-bold">$</div>
            <span className="font-semibold text-slate-700">USDC</span>
          </button>
        </div>

        {/* Dropdown Selection */}
        <div className="space-y-2">
           <Select value={currency} onValueChange={handleCurrencyChange}>
            <SelectTrigger className="h-14 text-lg rounded-xl border-slate-200" data-testid="select-currency">
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
          <div className="relative flex-1">
            <span className="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-slate-600">$</span>
            <Input 
              className="h-14 text-lg rounded-xl border-slate-200 pl-8" 
              placeholder="100" 
              value={nzdAmount}
              onChange={(e) => {
                const val = e.target.value;
                if (val === "" || parseFloat(val) >= 0) {
                  setNzdAmount(val);
                }
              }}
              min="0"
              step="1"
              data-testid="input-nzd-amount"
            />
            <span className="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">NZD</span>
          </div>
          <div className="text-slate-600 font-semibold text-lg whitespace-nowrap">
            = {cryptoAmount} {currency}
          </div>
        </div>

        {/* Donate Button */}
        <Button 
          onClick={() => setStep("personalInfo")}
          className="w-full h-14 rounded-xl text-lg font-bold bg-[#FCD535] text-black hover:bg-[#FCD535]/90 shadow-sm flex items-center justify-center gap-2"
          data-testid="button-donate"
        >
          Donate
          <Heart className="w-5 h-5 fill-black/20 stroke-black" />
        </Button>
      </CardContent>
    </Card>
  );
}
