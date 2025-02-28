import {
  __
} from "@wordpress/i18n";

// Imports from WordPress libraries
import {
  useBlockProps
} from "@wordpress/block-editor";

import {
  Icon,
  Placeholder,
  __experimentalGrid as Grid,
  __experimentalHeading as Heading,
  __experimentalSpacer as Spacer,
  __experimentalItem as Item,
  CheckboxControl,
  Button
} from "@wordpress/components";

import {
  CustomQueryControls
} from "../components/QueryControls";

interface EditProps {
  attributes: {
    category: string;
    num: number;
  },
  setAttributes: (attributes: Partial<EditProps["attributes"]>) => void;
}

export default function Edit({attributes, setAttributes}: EditProps) {
  const props = useBlockProps();

  return (
    <div {...props}>
      <Placeholder
        label={__("Downloads Block", "rrze-downloads")}
        instructions={__("Let's configure your downloads block..", "rrze-downloads")}
        isColumnLayout={true}
      >
        <div>
          <hr />
          <Heading level={3}>{__("Your current configuration", "rrze-downloads")}</Heading>
          <Spacer />
          <Grid columns={6}>
            <div style={{ gridColumn: "span 3" }}>
              <Heading level={4}>{__("Filter by File Type", "rrze-downloads")}</Heading>
              <Spacer />
              <CheckboxControl
                label={__("Text files", "rrze-downloads")}
                checked={true}
                help={__("Should the Download list contain Text files?", "rrze-downloads")}
                onChange={() => {
                }}
              />
              <CheckboxControl
                label={__("Images", "rrze-downloads")}
                checked={true}
                onChange={() => {
                }}
              />
              <CheckboxControl
                label={__("Audio files", "rrze-downloads")}
                checked={true}
                onChange={() => {
                }}
              />
            </div>
            <div style={{ gridColumn: "span 3" }}>
              <Heading level={4}>{__("Filter by Category or Tag", "rrze-downloads")}</Heading>
              <Spacer />
              <CustomQueryControls
                attributes={{
                  cat: attributes.category,
                  num: attributes.num,
                }}
                setAttributes={setAttributes}
              />
            </div>
          </Grid>
        </div>
      </Placeholder>
    </div>
  );
}