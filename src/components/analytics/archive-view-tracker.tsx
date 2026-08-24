"use client";

import { useEffect } from "react";
import { track } from "@/lib/analytics";

export default function ArchiveViewTracker() {
  useEffect(() => {
    track("archive viewed");
  }, []);
  return null;
}
