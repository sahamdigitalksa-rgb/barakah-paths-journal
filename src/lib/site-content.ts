import arabicImage from "@/assets/arabic-notes.jpg";
import homeschoolImage from "@/assets/homeschool-desk.jpg";
import walkImage from "@/assets/madinah-walk.jpg";

export const themes = [
  { name: "Family life", slug: "family-life", number: "01", description: "The ordinary days that make up the journey." },
  { name: "Homeschooling", slug: "homeschooling", number: "02", description: "Lessons, rhythms, and learning together." },
  { name: "Arabic & culture", slug: "arabic-culture", number: "03", description: "Language, customs, and a sense of place." },
  { name: "Faith", slug: "faith", number: "04", description: "Reflections on intention and everyday life." },
] as const;

export const sampleStories = [
  { title: "Finding words in a new place", category: "Arabic & culture", image: arabicImage, alt: "Illustrative image of an Arabic practice notebook on a table", description: "A space for reflections on learning Arabic and finding a voice in a new home." },
  { title: "Learning around the table", category: "Homeschooling", image: homeschoolImage, alt: "Illustrative image of books and notebooks on a homeschool table", description: "A space to record the first steps, routines, and surprises of learning together." },
  { title: "The moments between milestones", category: "Faith", image: walkImage, alt: "Illustrative image of a family walking through a Madinah-inspired street", description: "A space for the quiet moments that give a journey its meaning." },
] as const;

export const sampleVideos = [
  { title: "A day in Madinah", category: "Family life", image: walkImage, alt: "Illustrative street scene in Madinah" },
  { title: "Learning together", category: "Homeschooling", image: homeschoolImage, alt: "Illustrative homeschool table" },
] as const;
