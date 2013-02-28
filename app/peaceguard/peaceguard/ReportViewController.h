//
//  ReportViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MobileCoreServices/MobileCoreServices.h>

@interface ReportViewController : UIViewController <UITextFieldDelegate, UIImagePickerControllerDelegate, UINavigationControllerDelegate>
@property (weak, nonatomic) IBOutlet UIButton *Image;
//open the camera and take the picture
- (IBAction)ImageTaker:(id)sender;

@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property(strong, nonatomic) ReportViewController *reportController;
@property (weak, nonatomic) IBOutlet UIButton *submit;
- (IBAction) submitAction:(id)sender;
- (BOOL) verify: (NSString*) description;
@property (weak, nonatomic) IBOutlet UITextField *description;
//put the image in the specific place and show it to the user
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info;
@end
