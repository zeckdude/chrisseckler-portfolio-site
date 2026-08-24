import type { Metadata } from "next";
import ArchiveViewTracker from "@/components/analytics/archive-view-tracker";
import ArchiveCard from "@/components/archive/archive-card";
import { Reveal, RevealGroup } from "@/components/motion/reveal";
import { portfolioArchives } from "@/lib/archives";

export const metadata: Metadata = {
  title: "Portfolio Archive",
  description:
    "Past versions of chrisseckler.com — frozen snapshots you can browse in a new tab.",
};

export default function ArchivePage() {
  return (
    <div className="mx-auto max-w-content px-6 py-16">
      <ArchiveViewTracker />

      <Reveal className="max-w-2xl">
        <h1 className="font-display text-3xl font-extrabold tracking-tight text-text-primary sm:text-4xl">
          Portfolio archive
        </h1>
        <p className="mt-4 text-lg leading-relaxed text-text-secondary">
          A trip down memory lane. Each version is a frozen snapshot on its own subdomain —
          same layout and interactions as when it was live, without backends or databases.
        </p>
      </Reveal>

      <RevealGroup className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {portfolioArchives.map((archive) => (
          <Reveal key={archive.year}>
            <ArchiveCard archive={archive} />
          </Reveal>
        ))}
      </RevealGroup>
    </div>
  );
}
