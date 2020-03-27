# Changelog

## v0.2.0

### Changed

* The signature of the [ProductVariantUrlGeneratorInterface](src/UrlGenerator/ProductVariantUrlGeneratorInterface.php)
changed, so you need to rewrite your implementations of this interface. The change was made to better conform to Symfonys
`UrlGeneratorInterface` 

* The `setono_variant_link` twig function morphed into two functions: `setono_variant_path` and `setono_variant_url`.
Again to be more similar to Symfony conventions where you have the `path` and `url` functions.

* The shop routes file was moved [here](src/Resources/config/routes/shop.yaml).
