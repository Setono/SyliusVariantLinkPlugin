@viewing_product_variants
Feature: Viewing product variant details
  In order to see information about a product variant
  As a Visitor
  I want to be able to view a single product variant

  Background:
    Given the store operates on a single channel in "United States"

  Scenario: Viewing a detailed page with product variant's price
    Given the store has a product "T-shirt"
    And the product "T-shirt" has "Blue T-shirt" variant priced at "$10.00"
    And the product "T-shirt" has "Red T-shirt" variant priced at "$20.00"
    And the product "T-shirt" has "Green T-shirt" variant priced at "$30.00"
    When I check the details for variant "Red T-shirt"
    Then the product price should be "$20.00"
