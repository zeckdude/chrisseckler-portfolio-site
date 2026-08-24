"use client";

import Image from "next/image";
import { TechChipList } from "@/components/ui/tech-chip";
import { track } from "@/lib/analytics";
import type { PortfolioArchive } from "@/lib/archives";

export default function ArchiveCard({ archive }: { archive: PortfolioArchive }) {
  const isLive = archive.status === "live" && archive.url;

  return (
    <article className="flex h-full flex-col rounded-md border border-border bg-surface p-5 transition-all duration-200 ease-out hover:-translate-y-1 hover:border-accent/40">
      {archive.screenshot && (
        <div className="relative aspect-[16/10] overflow-hidden rounded bg-surface-elevated">
          <Image
            src={archive.screenshot}
            alt=""
            fill
            className="object-contain object-center"
            sizes="(max-width: 768px) 100vw, 400px"
          />
        </div>
      )}

      <div className="mt-4 flex flex-1 flex-col gap-3">
        <div className="flex items-baseline justify-between gap-3">
          <h2 className="font-display text-xl font-extrabold text-text-primary">
            {archive.title}
          </h2>
          <span className="font-mono text-xs text-text-secondary">{archive.year}</span>
        </div>

        <p className="text-sm leading-relaxed text-text-secondary">{archive.blurb}</p>

        <TechChipList items={archive.stack} max={6} className="mt-auto pt-1" />
      </div>

      <div className="mt-5 border-t border-border pt-4">
        {isLive ? (
          <a
            href={archive.url}
            target="_blank"
            rel="noopener noreferrer"
            onClick={() =>
              track("archive launched", { year: archive.year, url: archive.url })
            }
            className="inline-flex items-center gap-2 font-medium text-accent transition-opacity hover:opacity-80"
          >
            Launch archived site
            <span aria-hidden>↗</span>
          </a>
        ) : (
          <p className="text-sm font-medium text-text-secondary">Coming soon</p>
        )}
      </div>
    </article>
  );
}
