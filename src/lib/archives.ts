export type ArchiveStatus = "live" | "coming-soon";

export interface PortfolioArchive {
  year: number;
  title: string;
  stack: string[];
  blurb: string;
  /** Optional preview image (absolute URL or site path). */
  screenshot?: string;
  /** Live archive hostname — opens in a new tab when status is live. */
  url?: string;
  status: ArchiveStatus;
}

/** Past portfolio versions hosted on YYYY.archive.chrisseckler.com */
export const portfolioArchives: PortfolioArchive[] = [
  {
    year: 2024,
    title: "2024 Portfolio",
    stack: ["Express", "Nunjucks", "jQuery", "Bootstrap"],
    blurb:
      "The site live at chrisseckler.com from 2024 through the 2026 redesign — project masonry, modal case studies, and a single-page scroll layout.",
    screenshot:
      "https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/about.jpg",
    url: "https://2024.archive.chrisseckler.com",
    status: "live",
  },
];

export const liveArchives = portfolioArchives.filter((a) => a.status === "live");
