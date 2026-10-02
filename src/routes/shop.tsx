import { createFileRoute } from "@tanstack/react-router";
import morning from "@/assets/madinah-morning.jpg";
import desk from "@/assets/homeschool-desk.jpg";
import notes from "@/assets/arabic-notes.jpg";
import { PageIntro } from "@/components/site";

const guides = [
  { image: morning, category: "Hijrah planning", title: "Preparing for the move", description: "A practical checklist guide for families planning a move to Madinah." },
  { image: desk, category: "Homeschooling", title: "Starting homeschool abroad", description: "Routines, resources, and first-term planning." },
  { image: notes, category: "Arabic", title: "Everyday Arabic for families", description: "Phrases and habits for daily life." },
];

export const Route = createFileRoute("/shop")({ head: () => ({ meta: [{ title: "Digital Guides — Barakah Paths" }, { name: "description", content: "Downloadable guides for families on the path to Madinah: Hijrah planning, homeschooling abroad, and everyday Arabic." }, { property: "og:title", content: "Digital Guides — Barakah Paths" }, { property: "og:description", content: "Practical downloadable guides drawn from a family's journey to Madinah." }, { property: "og:url", content: "/shop" }, { property: "og:type", content: "website" }, { name: "twitter:card", content: "summary_large_image" }], links: [{ rel: "canonical", href: "/shop" }] }), component: Shop });

function Shop() {
  return <><PageIntro label="Digital guides" title="Resources for the journey" description="Downloadable guides drawn from what we are learning along the way."/>
    <section className="site-container section-block"><div className="story-grid">{guides.map(g => <article className="story-card" key={g.title}><img src={g.image} alt={`Illustrative cover for ${g.title}`} width={1024} height={768} loading="lazy"/><p className="category">{g.category}</p><h3>{g.title}</h3><p className="description">{g.description}</p><p className="category">Coming soon</p></article>)}</div>
    <p className="sample-note">Sample guides — titles, prices and checkout will come from WooCommerce on your WordPress site.</p></section></>;
}
