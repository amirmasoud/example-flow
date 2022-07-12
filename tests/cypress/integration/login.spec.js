describe("Authentication", () => {
  it("Provides feedback on failure", () => {
    cy.refreshDatabase();

    cy.visit("/login");
    cy.get("input[name=email]").type("foo@example.com");
    cy.get("input[name=password]").type("secret");
    cy.get("button[type=submit]").click();
    cy.wait(1000);
    cy.get("#email-error").should("exist");
  });

  it("Login successfully", () => {
    cy.refreshDatabase();

    cy.create("Domain\\Users\\Models\\User", { email: "bar@example.com" });
    cy.visit("/login");
    cy.get("input[name=email]").type("bar@example.com");
    cy.get("input[name=password]").type("password");
    cy.get("button[type=submit]").click();
    cy.assertRedirect("/dashboard");
  });
});
