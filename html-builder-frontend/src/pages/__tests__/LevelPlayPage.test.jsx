import React from "react";
import { render, screen } from "@testing-library/react";
import { BrowserRouter } from "react-router-dom";
import LevelPlayPage from "../LevelPlayPage";

test("prikazuje poruku ucitavanja", () => {
  render(
    <BrowserRouter>
      <LevelPlayPage />
    </BrowserRouter>
  );

  expect(screen.getByText(/Učitavanje nivoa/i)).toBeInTheDocument();
});

test("prikazuje gresku kada nivo nije pronadjen", async () => {
  global.fetch = vi.fn(() =>
    Promise.resolve({
      ok: false,
      json: () => Promise.resolve({}),
    })
  );

  render(
    <BrowserRouter>
      <LevelPlayPage />
    </BrowserRouter>
  );

  const errorMessage = await screen.findByText(/Nivo nije pronađen/i);
  expect(errorMessage).toBeInTheDocument();
});
