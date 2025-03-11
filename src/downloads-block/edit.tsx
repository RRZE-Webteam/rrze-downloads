import {
  __
} from "@wordpress/i18n";

// Imports from WordPress libraries
import {
  useBlockProps,
  BlockControls
} from "@wordpress/block-editor";

import {
  Icon,
  Placeholder,
  __experimentalGrid as Grid,
  __experimentalHeading as Heading,
  __experimentalSpacer as Spacer,
  __experimentalItem as Item,
  CheckboxControl,
  Button,
  Toolbar,
  ToolbarGroup,
  ToolbarButton
} from "@wordpress/components";

import {
  CustomQueryControls
} from "../components/QueryControls";

import {
  useState
} from "@wordpress/element"

import ServerSideRender from '@wordpress/server-side-render';

interface EditProps {
  attributes: {
    category: string | null;
    num: number;
    search_image: boolean;
    isInitialSetup: boolean;
    search_audio: boolean;
    search_text: boolean;
    search_application: boolean;
  },
  setAttributes: (attributes: Partial<EditProps["attributes"]>) => void;
}

export default function Edit({attributes, setAttributes}: EditProps) {
  const props = useBlockProps();
  const [isInitialSetup, setIsInitialSetup] = useState(attributes.isInitialSetup);

  const onClickInitialSetupConfirm = () => {
    setIsInitialSetup(false);
    setAttributes({isInitialSetup: false});
  }

  return (
    <div {...props}>
      {isInitialSetup ? (
        <>
          <BlockControls>
            <ToolbarGroup>
              <ToolbarButton>
                {"Test"}
              </ToolbarButton>
            </ToolbarGroup>
          </BlockControls>
          <Placeholder
            label={__("Downloads Block", "rrze-downloads")}
            instructions={__("Configure your downloads block..", "rrze-downloads")}
            isColumnLayout={true}
          >
            <div>
              <Spacer
                paddingTop={"1rem"}
                paddingBottom={"1rem"}
              >
                <hr/>
              </Spacer>
              <Grid columns={6}>
                <div style={{gridColumn: "span 3"}}>
                  <Spacer
                    paddingBottom={"1rem"}
                  >
                    <Heading level={4}>{__("Filter by Media Category", "rrze-downloads")}</Heading>
                  </Spacer>
                  <Spacer paddingRight={"2rem"}>
                    <CustomQueryControls
                      attributes={{
                        category: attributes.category || "",
                        num: attributes.num,
                      }}
                      setAttributes={setAttributes}
                    />
                  </Spacer>
                </div>
                <div style={{gridColumn: "span 3"}}>
                  <Heading level={4}>{__("Filter by File Type", "rrze-downloads")}</Heading>
                  <Spacer/>
                  <CheckboxControl
                    label={__("Text files", "rrze-downloads")}
                    checked={attributes.search_text}
                    help={__("Should the Download list contain Text files?", "rrze-downloads")}
                    onChange={() => setAttributes({
                      search_text: !attributes.search_text,
                    })}
                  />
                  <CheckboxControl
                    label={__("PDF & Application files", "rrze-downloads")}
                    checked={attributes.search_application}
                    help={__("Should the Download list contain PDF or other Application files?", "rrze-downloads")}
                    onChange={() => setAttributes({
                      search_application: !attributes.search_application,
                    })}
                  />
                  <CheckboxControl
                    label={__("Images", "rrze-downloads")}
                    checked={attributes.search_image}
                    help={__("Should the Download list contain jpg/jpeg, png or other image formats?", "rrze-downloads")}
                    onChange={() => setAttributes({
                      search_image: !attributes.search_image,
                    })}
                  />
                  <CheckboxControl
                    label={__("Audio files", "rrze-downloads")}
                    help={__("Should the Download list contain audio files?", "rrze-downloads")}
                    checked={attributes.search_audio}
                    onChange={() => setAttributes({
                      search_audio: !attributes.search_audio,
                    })}
                  />
                </div>
              </Grid>
            </div>
            <div>
              <Button
                variant="primary"
                onClick={onClickInitialSetupConfirm}
              >
                {__("Finish initial setup", "rrze-downloads")}
              </Button>
              <Spacer
                paddingTop={"1rem"}
              >
                <hr/>
              </Spacer>
              <Heading>{__("Preview", "rrze-downloads")}</Heading>
              <ServerSideRender
                block="rrze-downloads/downloads"
                attributes={attributes}
              />
              <Spacer/>
            </div>
          </Placeholder>
        </>
      ) : (
        <>
          <ServerSideRender
            block="rrze-downloads/downloads"
            attributes={attributes}
          />
        </>
      )}
    </div>
  );
}