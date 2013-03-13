//
//  ReportViewController.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import <UIKit/UIKit.h>
#import <MobileCoreServices/MobileCoreServices.h>
#import <CoreLocation/CoreLocation.h>

@interface ReportViewController : UIViewController <UITextFieldDelegate, UIImagePickerControllerDelegate, UINavigationControllerDelegate>
@property (weak, nonatomic) IBOutlet UIButton *Image;
//open the camera and take the picture
- (IBAction)ImageTaker:(id)sender;

@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property(strong, nonatomic) ReportViewController *reportController;

//PickerView
@property (strong, nonatomic) IBOutlet UIPickerView *thePickerView;
//used to block other fields when using pickerview
@property (strong, nonatomic) IBOutlet UIView *pickerViewBlocker;
//-incident/severity array
@property (strong, nonatomic) NSArray *incidentSelection;
@property (strong, nonatomic) NSArray *severitySelection;
@property (strong, nonatomic) IBOutlet UILabel *incidentLabel;
@property (strong, nonatomic) IBOutlet UILabel *severityLabel;
//-Data from pickerview
@property (strong, nonatomic) NSString *incidentData;   //change to be consistent with server - same as severity
@property (strong, nonatomic) NSString *severityData;
@property (weak, nonatomic) IBOutlet UITextField *locationDisplay;
@property (weak, nonatomic) IBOutlet UITextField *dateDisplay;

//temp variable for overview
@property (strong, nonatomic) NSString *incidentOverview;
@property (strong, nonatomic) NSString *severityOverview;
@property (strong, nonatomic) NSString *descriptionOverview;
@property (strong, nonatomic) UIImage *imageOverview;

//-open/close pickerview for incident type/severity
- (IBAction)incidentButtonPressed:(id)sender;
- (IBAction)severityButtonPressed:(id)sender;
- (IBAction)doneSelection:(id)sender;


- (IBAction)buttonToOverview:(id)sender;


- (BOOL) verify: (NSString*) description;

@property (nonatomic) CLLocation *location;

@property (weak, nonatomic) IBOutlet UITextField *description;
//put the image in the specific place and show it to the user
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info;
@end
