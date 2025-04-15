import {
  __
} from "@wordpress/i18n";

// Imports from WordPress libraries
import {
  useBlockProps,
  BlockControls,
  InspectorControls
} from "@wordpress/block-editor";

import {
  Placeholder,
  __experimentalGrid as Grid,
  __experimentalHeading as Heading,
  __experimentalSpacer as Spacer,
  __experimentalToggleGroupControl as ToggleGroupControl,
  __experimentalToggleGroupControlOption as ToggleGroupControlOption,
  CheckboxControl,
  Button,
  ToolbarGroup,
  ToolbarItem,
  ToolbarDropdownMenu,
  PanelBody,
  TextControl
} from "@wordpress/components";

import {
  table as tableIcon,
  list as listIcon,
  styles as stylesIcon
} from "@wordpress/icons";

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
    format: string;
    showsize: boolean;
    showexcerpt: boolean;
    showcreated: boolean;
    showcontent: boolean;
    errormsg: string;
    orderby: string;
    sort: string;
    tags: string;
  },
  setAttributes: (attributes: Partial<EditProps["attributes"]>) => void;
}

interface ToolbarFormatOption {
  key: string;
  title: string;
  icon: any;
  onClick: () => void;
}

export default function Edit({attributes, setAttributes}: EditProps) {
  const props = useBlockProps();
  const [isInitialSetup, setIsInitialSetup] = useState(attributes.isInitialSetup);

  const onClickInitialSetupConfirm = () => {
    setIsInitialSetup(false);
    setAttributes({isInitialSetup: false});
  }

  const formatOptions: ToolbarFormatOption[] = [
    {
      key: "liste",
      title: __("List", "rrze-downloads"),
      icon: listIcon,
      onClick: () => {
        setAttributes({format: "liste"});
      },
    },
    {
      key: "table",
      title: __("Table", "rrze-downloads"),
      icon: tableIcon,
      onClick: () => {
        setAttributes({format: "table"});
      },
    },
  ];

  return (
    <div {...props}>
      {isInitialSetup ? (
        <>
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
                        tags: attributes.tags,
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
              <Heading>{__("Data Preview", "rrze-downloads")}</Heading>
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
          <InspectorControls>
            <PanelBody title={__("Filter options", "rrze-downloads")} initialOpen={false}>
              <div>
                <Spacer paddingRight={"0.2rem"}>
                  <CustomQueryControls
                    attributes={{
                      category: attributes.category || "",
                      num: attributes.num,
                      tags: attributes.tags,
                    }}
                    setAttributes={setAttributes}
                  />
                </Spacer>
              </div>
              <div>
                <Spacer paddingTop={"1rem"}>
                  <Heading level={3}>{__("Filter by File Type", "rrze-downloads")}</Heading>
                </ Spacer>
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
            </PanelBody>
            <PanelBody title={__("Appearance", "rrze-downloads")} initialOpen={false}>
              <>
                <ToggleGroupControl
                  __next40pxDefaultSize
                  isBlock
                  label={__("Format options", "rrze-downloads")}
                  onChange={(newFormat: string) => setAttributes({format: newFormat})}
                  value={attributes.format}
                  help={__("Select a layout for the Download list.", "rrze-downloads")}
                >
                  <ToggleGroupControlOption
                    label={__("Liste", "rrze-downloads")}
                    value="liste"
                  />
                  <ToggleGroupControlOption
                    label={__("Tabelle", "rrze-downloads")}
                    value="table"
                  />
                </ToggleGroupControl>
                <CheckboxControl
                  label={__("Show file size", "rrze-downloads")}
                  checked={attributes.showsize}
                  help={__("Should the file size be displayed in kB?", "rrze-downloads")}
                  onChange={() => setAttributes({
                    showsize: !attributes.showsize,
                  })}
                />
                <CheckboxControl
                  label={__("Show creation date", "rrze-downloads")}
                  checked={attributes.showcreated}
                  help={__("Should the upload date be displayed?", "rrze-downloads")}
                  onChange={() => setAttributes({
                    showcreated: !attributes.showcreated,
                  })}
                />
                <CheckboxControl
                  label={__("Show Excerpt", "rrze-downloads")}
                  checked={attributes.showexcerpt}
                  help={__("Should the Media Caption be displayed?", "rrze-downloads")}
                  onChange={() => setAttributes({
                    showexcerpt: !attributes.showexcerpt,
                  })}
                />
                <CheckboxControl
                  label={__("Show content", "rrze-downloads")}
                  help={__("Should the Medias description be displayed?", "rrze-downloads")}
                  checked={attributes.showcontent}
                  onChange={() => setAttributes({
                    showcontent: !attributes.showcontent,
                  })}
                />
                <TextControl
                  __next40pxDefaultSize
                  __nextHasNoMarginBottom
                  help={__("Modify the error message that is displayed, when no Media items are found.", "rrze-downloads")}
                  label={__("Custom Error Message", "rrze-downloads")}
                  onChange={(newErrorMessage) => {
                    setAttributes({errormsg: newErrorMessage})
                  }}
                  value={attributes.errormsg}
                />
              </>
            </PanelBody>
            <PanelBody title={__("Order & Sorting direction", "rrze-downloads")} initialOpen={false}>
              <>
                <ToggleGroupControl
                  __next40pxDefaultSize
                  isBlock
                  label={__("Order", "rrze-downloads")}
                  onChange={(newOrder: string) => setAttributes({orderby: newOrder})}
                  value={attributes.orderby}
                  help={__("Sort your Download list by title or creation date.", "rrze-downloads")}
                >
                  <ToggleGroupControlOption
                    label={__("Title", "rrze-downloads")}
                    value="title"
                  />
                  <ToggleGroupControlOption
                    label={__("Date", "rrze-downloads")}
                    value="date"
                  />
                </ToggleGroupControl>
                <ToggleGroupControl
                  __next40pxDefaultSize
                  isBlock
                  label={__("Sorting direction", "rrze-downloads")}
                  onChange={(newOrder: string) => setAttributes({sort: newOrder})}
                  value={attributes.sort}
                  help={__("Display your Download list ascending or descending", "rrze-downloads")}
                >
                  <ToggleGroupControlOption
                    label={__("Ascending order", "rrze-downloads")}
                    value="asc"
                  />
                  <ToggleGroupControlOption
                    label={__("Descending order", "rrze-downloads")}
                    value="desc"
                  />
                </ToggleGroupControl>
              </>
            </PanelBody>
          </InspectorControls>
          <BlockControls>
            <ToolbarGroup>
              <ToolbarItem>
                {() => (
                  <ToolbarDropdownMenu
                    icon={attributes.format === "liste" ? listIcon : tableIcon}
                    label={__("Change the Layout", "rrze-elements-blocks")}
                    controls={formatOptions}
                  />
                )}
              </ToolbarItem>
            </ToolbarGroup>
          </BlockControls>
          <ServerSideRender
            block="rrze-downloads/downloads"
            attributes={attributes}
          />
        </>
      )}
    </div>
  );
}