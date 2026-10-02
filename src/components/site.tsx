import { Link } from "@tanstack/react-router";
import { ArrowUpRight, Menu, X } from "lucide-react";
import { useState } from "react";
import { Button } from "@/components/ui/button";

const links = [
  { to: "/", label: "Home" },
  { to: "/journal", label: "Journal" },
  { to: "/videos", label: "Videos" },
  { to: "/themes", label: "Themes" },
  { to: "/about", label: "About" },
] as const;

export function Mark({ light = false }: { light?: boolean }) {
  return <span className={`brand-mark ${light ? "brand-mark-light" : ""}`} aria-hidden="true"><svg viewBox="0 0 48 48" fill="none"><path d="M10 34c7-12 12-13 18-12 5 1 7-2 10-8" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"/><path d="M12 13v21M12 13h10c8 0 8 10 0 10H12m0 0h12c9 0 9 11 0 11H12" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" strokeLinejoin="round"/></svg></span>;
}

export function Header() {
  const [open, setOpen] = useState(false);
  return <header className="site-header"><div className="site-container header-inner">
    <Link to="/" className="brand" onClick={() => setOpen(false)} aria-label="Barakah Paths home"><Mark/><span>Barakah Paths</span></Link>
    <nav className={`main-nav ${open ? "is-open" : ""}`} aria-label="Main navigation">{links.map(item => <Link key={item.to} to={item.to} {...(item.to === "/journal" ? { search: { theme: undefined } } : {})} onClick={() => setOpen(false)} activeProps={{ className: "active" }} activeOptions={{ exact: true }}>{item.label}</Link>)}</nav>
    <Button asChild className="header-cta"><Link to="/about">Our story <ArrowUpRight size={16}/></Link></Button>
    <Button variant="ghost" size="icon" className="mobile-toggle" onClick={() => setOpen(!open)} aria-label={open ? "Close menu" : "Open menu"} aria-expanded={open}>{open ? <X/> : <Menu/>}</Button>
  </div></header>;
}

export function Footer() {
  return <footer className="site-footer"><div className="site-container footer-top"><Link to="/" className="brand"><Mark/><span>Barakah Paths</span></Link><p>A family journal of faith, learning, and the paths in between.</p></div><div className="site-container footer-bottom"><span>From Singapore to Madinah, with intention.</span><span>© {new Date().getFullYear()} Barakah Paths</span></div></footer>;
}

export function PageIntro({ label, title, description }: {label: string; title: string; description: string}) {
 return <div className="page-intro site-container"><p className="eyebrow">{label}</p><h1>{title}</h1><p className="intro-text">{description}</p></div>
}

export function SampleNote() { return <p className="sample-note">Illustrative preview — stories and images will be replaced with your own.</p> }
