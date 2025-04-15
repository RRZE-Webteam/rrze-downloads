import {useSelect} from "@wordpress/data";
import {FormTokenField, ComboboxControl, __experimentalText as Text} from "@wordpress/components";
import {__} from "@wordpress/i18n";

type CustomQueryControlsProps = {
  attributes: {
    category: string;
    num: number;
    tags: string;
  };
  setAttributes: (attributes: Partial<CustomQueryControlsProps["attributes"]>) => void;
};

interface Category {
  slug: string;
  name: string;
  id: number;
  count: number;
  link: string;
  parent: number;
  taxonomy: string;
  description: string;
}

interface CategoryOption {
  label: string;
  files: number;
  description?: string;
  value: string;
}

const CustomQueryControls = ({attributes, setAttributes}: CustomQueryControlsProps) => {
  const {categories, tags} = useSelect((select) => {
    const {getEntityRecords} = select("core") as {
      getEntityRecords: (
        kind: string,
        name: string,
        query?: { per_page: number }
      ) => Category[];
    };

    return {
      categories: getEntityRecords("taxonomy", "attachment_category", {
        per_page: -1,
      }),
      tags: getEntityRecords("taxonomy", "attachment_tag", {
        per_page: -1,
      }),
    };
  }, []);

  const {category = ""} = attributes;
  const selectedCategorySlugs = category.split(",").filter(Boolean);

  const tagSuggestions = tags?.map((tag) => tag.slug) || [];

  const categorySuggestions = categories
    ? categories.map((category) => category.slug)
    : [];

  const onCategoryChange = (newSlug: string | null) => {
    setAttributes({category: newSlug});
  };

  const categoryOptions = categories
    ? categories.map((category) => ({
      label: category.name,
      value: category.slug,
      files: category.count,
      description: category.description,
    }))
    : [];

  const renderExperimentalRenderItem = (item: any) => {
    return (
      <>
        <div style={{marginBottom: ".2rem"}}>
          <strong>{item.item.label}</strong><br/>
        </div>
        <small>{item.item.files}{(item.item.files > 1) ? __(" files in this category: ", "rrze-downloads") : __(" file in this category: ", "rrze-downloads")}</small>
        {item.item.description && (
          <>
            <br/>
            <small><em>{item.item.description}</em></small>
          </>
        )}
      </>
    )
  }

  return (
    <>
      {(categoryOptions.length > 0) ? (
        <ComboboxControl
          __experimentalRenderItem={renderExperimentalRenderItem}
          options={categoryOptions}
          onChange={onCategoryChange}
          label={__("Filter by Category", "rrze-downloads")}
          help={__("Select a category to filter the downloads by.", "rrze-downloads")}
          value={attributes.category}
        />
      ) : (
        <>
          <Text>{__("You currently have no Media Categories setup and in use. Follow these steps to create a custom Media Category:", "rrze-downloads")}</Text>
          <ol>
            <li>{__("Navigate to Dashboard > Media Library > Categories", "rrze-downloads")}</li>
            <li>{__("Create a new Media Category with a descriptive name and a description.", "rrze-downloads")}</li>
            <li>{__("Start adding new Media items to your categories via your WordPress Media Library (Dashboard > Media Library)", "rrze-downloads")}</li>
            <li>{__("Save your current post or page and refresh the Editor to filter your download list by your newly created Media Library.", "rrze-downloads")}</li>
          </ol>
        </>
      )}
      <FormTokenField
        label={__("Select Tags", "rrze-downloads")}
        value={attributes.tags ? attributes.tags.split(",").filter(Boolean) : []}
        disabled={tagSuggestions.length === 0}
        suggestions={tagSuggestions}
        onChange={(newTokens: string[]) => {
          const filteredTokens = newTokens.filter((token) =>
            tagSuggestions.includes(token)
          );

          setAttributes({tags: filteredTokens.join(",")});
        }}
        __experimentalShowHowTo={false}
      />
      {(tagSuggestions.length === 0) && (
        <>
          <Text>{__("You currently have no Media Tags setup and in use. Follow these steps to create a custom Media Tag:", "rrze-downloads")}</Text>
          <ol>
            <li>{__("Navigate to Dashboard > Media Library > Tags", "rrze-downloads")}</li>
            <li>{__("Create a new Media Tag with a descriptive name and a description.", "rrze-downloads")}</li>
            <li>{__("Start adding new Media items to your tags via your WordPress Media Library (Dashboard > Media Library)", "rrze-downloads")}</li>
            <li>{__("Save your current post or page and refresh the Editor to filter your download list by your newly created Media Library Tags.", "rrze-downloads")}</li>
          </ol>
        </>
      )}
    </>
  );
};

export {CustomQueryControls};
